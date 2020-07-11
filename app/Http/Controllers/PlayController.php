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

        $parentfolder = $parentfolderid = '';
        if ($presentationid) {
            $presentation = json_decode($mediasite->get($url . "/Presentations('$presentationid')?\$select=full")->getBody(), true);
            $presentations = array($presentation);
            $parentfolder = $presentation['ParentFolderName'];
            $parentfolderid = $presentation['ParentFolderId'];
        } else {
            if ($folderid) {
                $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000&\$select=full")->getBody(), true)['value'];
                $parent = json_decode($mediasite->get($url . "/Folders('$folderid')")->getBody(), true);
                $parentfolder = $parent['Name'];
                $parentfolderid = $parent['ParentFolderId'];
            }
        }
        /*
        if (!is_dir(public_path() . '/mediasite')) {
            mkdir(public_path() . '/mediasite');
        }
        */
        // Changed from public to storage
        if (!is_dir(base_path() . '/storage/app/public/mediasite')) {
            mkdir(base_path() . '/storage/app/public/mediasite');
        }
        /*
        if (!is_dir(public_path() . '/mediasite/' . $parentfolder)) {
            mkdir(public_path() . '/mediasite/' . $parentfolder);
        }
        */
        // Changed from public to storage
        if (!is_dir(base_path() . '/storage/app/public/mediasite/' . $parentfolder)) {
            mkdir(base_path() . '/storage/app/public/mediasite/' . $parentfolder);
        }
        // Check one level up
        $onefolderupid = json_decode($mediasite->get($url . "/Folders('$parentfolderid')")->getBody(), true)['ParentFolderId'];
        $topfoldername = json_decode($mediasite->get($url . "/Folders('$onefolderupid')")->getBody(), true);

        foreach ($presentations as $presentation) {
            $presentationid = $presentation['Id'];
            $title = trim($presentation['Title']);
            //Storage::makeDirectory('/public/mediasite/' . $parentfolder . '/' . $title);
            /*
            if (!is_dir(public_path() . '/mediasite/' . $parentfolder . '/' . $title)) {
                mkdir(public_path() . '/mediasite/' . $parentfolder . '/' . $title);
            }
            */
            // Changed from public to storage
            if (!is_dir(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title)) {
                mkdir(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title);
            }
            // Now let's create a json with all relevant metadata
            $metadata = array(
                'mediasiteid' => $presentation['Id'],
                'title' => $title,
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
                    /*
                    if (!file_exists(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename)) {
                        // download only if it hasn't been done before
                        file_put_contents(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                    }
                    if (filesize(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                        // filesize doesn't match! retrying.
                        echo 'Filesize does not match. Error!';
                        file_put_contents(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                    }
                    */
                    // Changed from public to storage
                    if (!file_exists(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title . '/' . $filename)) {
                        // download only if it hasn't been done before
                        file_put_contents(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                    }
                    if (filesize(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                        // filesize doesn't match! retrying.
                        echo 'Filesize does not match. Error!';
                        file_put_contents(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                    }
                    $metadata['sources'][$stream['StreamType']] = $filename;
                }
            }
            /*
            file_put_contents(public_path() . '/mediasite/' . $parentfolder . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            */
            // Changed from public to storage
            file_put_contents(base_path() . '/storage/app/public/mediasite/' . $parentfolder . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            // Let's import the data to videos table.
            $video = Video::firstOrNew(array('title' => $metadata['title']));
            $video->title = $metadata['title'];
            $video->length = $metadata['length'];
            $video->tags = implode(', ', $metadata['tags']);
            $video->source1 = array_key_exists('Video1', $metadata['sources']) ? './storage/mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video1'] : null;
            $video->source2 = array_key_exists('Video2', $metadata['sources']) ? './storage/mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video2'] : null;
            $video->source3 = array_key_exists('Video3', $metadata['sources']) ? './storage/mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video3'] : null;
            $video->source4 = array_key_exists('Video4', $metadata['sources']) ? './storage/mediasite/' . $parentfolder . '/' . $title . '/' . $metadata['sources']['Video4'] : null;

            // We also need to create a course and a category.
            if ($topfoldername['Name'] == 'Courses') {
                $course_name = $parentfolder;
                $term = array();
                $re = '/([V|H|S]T)(19|20)\d{2}/';
                preg_match($re, $title, $term, 0, 0);
                $semester = $year = 'Unknown';
                if ($term && $term[0]) {
                    $semester = substr($term[0], 0, 2);
                    $year = substr($term[0], 2, 4);
                }
                $course = Course::firstOrCreate(array('course_name' => $course_name, 'semester' => $semester, 'year' => $year));
                $course_id = $course->id;
            } else {
                $course = Course::firstOrCreate(array('course_name' => 'Recording'));
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
