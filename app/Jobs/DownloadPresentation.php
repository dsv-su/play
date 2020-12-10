<?php

namespace App\Jobs;

use App\Course;
use App\MediasitePresentation;
use App\Services\AuthHandler;
use App\Video;
use App\VideoCourse;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadPresentation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $presentation;
    protected $type;
    protected $path;
    protected $foldername;

    /**
     * Create a new job instance.
     *
     * @param MediasitePresentation $presentation
     * @param $type
     * @param $path
     * @param $foldername
     */
    public function __construct(MediasitePresentation $presentation, $type, $path, $foldername)
    {
        $this->presentation = $presentation;
        $this->type = $type;
        $this->path = $path;
        $this->foldername = $foldername;
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws Exception
     */
    public function handle()
    {
        $system = new AuthHandler();
        $system = $system->authorize();
        $mediasite = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'sfapikey' => $system->mediasite->sfapikey,
            ],
            'auth' => [$system->mediasite->username, $system->mediasite->password]
        ]);
        $url = $system->mediasite->url;
        try {
            $presentationid = $this->presentation->mediasite_id;
            $presentation = json_decode($mediasite->get($url . "/Presentations('$presentationid')?\$select=full")->getBody(), true);
            // Check if it's already downloaded
            $locallysaved = MediasitePresentation::where('mediasite_id', $presentationid)
                ->where('status', 1)->first();
            // We skip only if mediasite presentation has a correct pointer to a local video
            if ($locallysaved && $locallysaved->video_id) {
                return true;
            }

            $title = trim($presentation['Title']);

            // Now let's create a json with all relevant metadata
            $metadata = array(
                'mediasiteid' => $presentation['Id'],
                'title' => $title,
                'description' => $presentation['Description'],
                'recorded' => $presentation['RecordDate'],
                'duration' => $presentation['Duration'],
                'owner' => $presentation['Owner'],
                'tags' => $presentation['TagList']
            );

            // Presenters
            $presenters = array();
            try {
                $presenters = json_decode($mediasite->get($url . "/Presentations('$presentationid')/Presenters")->getBody(), true)['value'];
            } catch (GuzzleException $e) {
                abort(503);
            }
            foreach ($presenters as $presenter) {
                $metadata['presenters'][] = array('fullname' => $presenter['DisplayName'], 'email' => $presenter['Email']);
            }

            $streams = array();
            try {
                $streams = json_decode($mediasite->get($url . "/Presentations('$presentationid')/OnDemandContent")->getBody(), true)['value'];
            } catch (GuzzleException $e) {
                abort(503);
            }

            $emptystreams = true;
            foreach ($streams as $stream) {
                $filename = $stream['FileNameWithExtension'];
                // Skip zero length
                if ($stream['Length'] > 0) {
                    $emptystreams = false;
                    $streamurl = "https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/$filename";
                    $client = new Client();
                    if (!file_exists($this->path . $title . '/' . $filename)) {
                        // download only if it hasn't been done before
                        if (!is_dir($this->path . $title)) {
                            mkdir($this->path . $title);
                        }
                        $client->request('GET', $streamurl, ['sink' => $this->path . '/' . $title . '/' . $filename]);
                    }
                    if (filesize($this->path . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                        // filesize doesn't match! retrying.
                        echo "Filesize does not match. Error!\n";
                        $client->request('GET', $streamurl, ['sink' => $this->path . '/' . $title . '/' . $filename]);
                    }
                    $metadata['sources'][] = array(
                        'video' => "./storage/mediasite/$this->type/$this->foldername/$title/$filename",
                        'poster' => '',
                        'audio' => true
                    );
                }
            }

            if ($emptystreams) {
                return false;
            }

            // Save metadata json
            file_put_contents($this->path . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            // Let's import the data to videos table.
            // Maybe use mediasiteID to ensure that we don't download same thing twice?
            $video = new Video;
            $video->title = $metadata['title'];
            $video->duration = (new Carbon($metadata['duration'] ?? null))->format('H:i');
            $video->tags = implode(', ', $metadata['tags']);

            $semester = $year = 'Unknown';
            if ($this->type == 'course') {
                // We also need to create a course and a category.
                $term = array();
                $re = '/([V|H|S]T)(19|20)\d{2}/';
                preg_match($re, $title, $term, 0, 0);
                if ($term && $term[0]) {
                    $semester = substr($term[0], 0, 2);
                    $year = substr($term[0], 2, 4);
                }
            }
            $course = Course::firstOrCreate(array('course_name' => $this->foldername, 'semester' => $semester, 'year' => $year));

            // Dummy for now. We don't have categories
            $video->category_id = 1;

            // Store JSON
            $video->presentation = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            $video->save();

            // Update presentsation status
            $localpresentation = MediasitePresentation::where('mediasite_id', $presentationid)->firstOrFail();
            $localpresentation->status = 1;
            $localpresentation->video_id = $video->id;
            $localpresentation->save();

            // Assign course
            VideoCourse::create(array('video_id' => $video->id, 'course_id' => $course->id));

            return true;
        } catch (GuzzleException $e) {
            report($e);
        }
    }
}
