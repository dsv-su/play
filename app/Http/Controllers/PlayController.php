<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\UploadHandler;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Services\AuthHandler;

class PlayController extends Controller
{
    public function index()
    {
        // If the environment is local
        if (app()->environment('local')) {
            $data['play_user'] = 'Profil';
        } else {
            $data['play_user'] = $_SERVER['displayName'];
        }

        $data['search'] = 0;
        $data['latest'] = Video::with('category', 'course')->latest('id')->take(8)->get();
        $data['categories'] = Category::all();

        return view('home.index', $data);
    }

    public function player(Video $video)
    {
        $playlist = Video::where('course_id', $video->course->id)->get();
        //dd($playlist);
        return view('player.index', ['video' => $video, 'playlist' => $playlist]);
    }

    public function mediasite()
    {
        return view('home.mediasite');
    }

    public function mediasiteDownload()
    {
        $presentationid = request()->presentationid ?? null;
        $folderid = request()->folderid ?? null;

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

        $parentfolder = '';
        if ($presentationid) {
            $presentation = json_decode($mediasite->get($url . "/Presentations('$presentationid')?\$select=full")->getBody(), true);
            $presentations = array($presentation);
            $parentfolder = $presentation['ParentFolderName'];
        } else {
            if ($folderid) {
                $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000&\$select=full")->getBody(), true)['value'];
                $parentfolder = json_decode($mediasite->get($url . "/Folders('$folderid')")->getBody(), true)['Name'];
            }
        }

        if (!is_dir(public_path() . '/mediasite')) {
            mkdir(public_path() . '/mediasite');
        }
        if (!is_dir(public_path() . '/mediasite/' . $parentfolder)) {
            mkdir(public_path() . '/mediasite/' . $parentfolder);
        }

        foreach ($presentations as $presentation) {
            $presentationid = $presentation['Id'];
            $title = trim($presentation['Title']);
            //Storage::makeDirectory('/public/mediasite/' . $parentfolder . '/' . $title);
            if (!is_dir(public_path() . '/mediasite/' . $parentfolder . '/' . $title)) {
                mkdir(public_path() . '/mediasite/' . $parentfolder . '/' . $title);
            }
            // Now let's create a json with all relevant metadata
            $metadata = array(
                'mediasiteid' => $presentation['Id'],
                'title' => $presentation['Title'],
                'description' => $presentation['Description'],
                'recorded' => $presentation['RecordDate'],
                'length' => $presentation['Duration'],
                'owner' => $presentation['Owner'],
                'tags' => $presentation['TagList']
            );

            // Presenters
            $response = $mediasite->get($url . "/Presentations('$presentationid')/Presenters");
            $presenters = json_decode($response->getBody(), true)['value'];
            foreach ($presenters as $presenter) {
                $metadata['presenters'][] = array('fullname' => $presenter['DisplayName'], 'email' => $presenter['Email']);
            }

            $response = $mediasite->get($url . "/Presentations('$presentationid')/OnDemandContent");
            $streams = json_decode($response->getBody(), true)['value'];
            foreach ($streams as $stream) {
                $filename = $stream['FileNameWithExtension'];
                // Skip zero length
                if ($stream['Length'] > 0) {
                    $streamurl = "https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/$filename";
                    if (filesize(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                        // download only if it hasn't been done before
                        file_put_contents(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                    }
                    if (filesize(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                        // filesize doesn't match!
                        echo 'Filesize does not match. Error!';
                    }
                    $metadata['sources'][$stream['StreamType']] = $filename;
                }
            }

            file_put_contents(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            // Let's import the data to videos table.
            $video = Video::firstOrNew(array('title' => $metadata['title']));
            $video->title = $metadata['title'];
            $video->length = $metadata['length'];
            $video->tags = implode(', ', $metadata['tags']);
            $video->source1 = array_key_exists('Video1', $metadata['sources']) ? 'mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video1'] : null;
            $video->source2 = array_key_exists('Video2', $metadata['sources']) ? 'mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video2'] : null;
            $video->source3 = array_key_exists('Video3', $metadata['sources']) ? 'mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video3'] : null;
            $video->source4 = array_key_exists('Video4', $metadata['sources']) ? 'mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video4'] : null;

            // We also need to create a course and a category.
            if (in_array('Course', $metadata['tags'])) {
                $course_name = explode(' ', $metadata['title'])[0];
                $semester = substr(explode(' ', $metadata['title'])[1], 0, 2);
                $year = substr(explode(' ', $metadata['title'])[1], 2, 4);
                $course = Course::firstOrCreate(array('course_name' => $course_name, 'semester' => $semester, 'year' => $year));
                $course_id = $course->id;
            }
            $video->course_id = $course_id;
            // Dummy for now.
            $video->category_id = 1;
            $video->save();
        }

        return redirect()->route('home');
    }

    public function upload()
    {
        $data['upload'] = 0;
        return view('video.test', $data);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = Storage::putFileAs('public', $request->file('file'), 'upload.txt');
            if ($request->file('file')->extension() == 'txt') {
                //Multiple streams
                $streams = new UploadHandler();
                $streams = $streams->getUpload($path);
                $x = 1;
                foreach ($streams as $stream) {
                    //Storage::putFileAs('public', new File($stream), 'myvideo'.$x.'.mp4');
                    //
                    //$list[] =  Storage::url('myvideo'.$x.'.mp4');
                    $list[] = $stream;
                    $x++;
                }
                $data['upload'] = 1;
                $data['url'] = $list;
                return view('video.test', $data);
            } elseif ($request->file('file')->extension() == 'mp4') {
                //Singel stream

                //Store uploaded file in folder
                Storage::putFileAs('public', new File($request->file('file')), 'myvideo.mp4');
                $url = Storage::url('myvideo.mp4');
                $data['upload'] = 1;
                //$data['url'] = $url;
                $list[] =  $url;
                $data['url'] = $list;
                return view('video.test', $data);
            }
        }
    }
}
