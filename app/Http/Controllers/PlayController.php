<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Services\ConfigurationHandler;
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

        //Initiate system
        $init = new ConfigurationHandler();
        $init->check_system();

        $data['search'] = 0;
        $data['latest'] = Video::with('category', 'course')->latest('id')->take(8)->get();
        $data['categories'] = Category::all();

        return view('home.index', $data);
    }

    public function player(Video $video)
    {
        $playlist = Video::where('course_id', $video->course->id)->get();

        return view('player.index', ['video' => $video, 'playlist' => $playlist]);
        //return view('player.index2', ['video' => $video, 'playlist' => $playlist]);
    }

    public function mediasite()
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

        $coursesfolderid = '1348b01a935b48c59abc6dd3e46cf7c714';
        $usersfolderid = '94832c6219754477a178e401f1637caf14';
        $untitledfolderid = '59a0ee17d4154c6884e5dc98f5a00c8914';
        $recordingsfolderid = '73213fc87f634675b9f34456f35115c314';

        $courses = $recordings = array();

        $folders = json_decode($mediasite->get($url . "/Folders?\$top=1000000")->getBody(), true)['value'];
        foreach ($folders as $folder) {
            if ($folder['ParentFolderId'] == $coursesfolderid) {
                $courses[$folder['Id']] = $folder['Name'];
            }
            if ($folder['ParentFolderId'] == $usersfolderid) {
                $users[$folder['Id']] = $folder['Name'];
            }
        }

        asort($courses);
        asort($users);

        return view('home.mediasite', ['courses' => $courses, 'users' => $users]);
    }

    public function mediasiteUserDownload()
    {
        $folderid = request()->folderid ?? null;
        $username = request()->username ?? null;

        $this->processDownload('user', $username, $folderid);

        return redirect()->route('home');
    }

    public function mediasiteCourseDownload()
    {
        $folderid = request()->folderid ?? null;
        $coursename = request()->coursename ?? null;

        $this->processDownload('course', $coursename, $folderid);

        return redirect()->route('home');
    }

    public function processDownload($type, $foldername, $folderid)
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

        if (!is_dir(base_path() . "/storage/app/public/mediasite/$type/")) {
            mkdir(base_path() . "/storage/app/public/mediasite/$type/");
        }
        $path = base_path() . "/storage/app/public/mediasite/$type/" . $foldername . '/';
        if (!is_dir($path)) {
            mkdir($path);
        }

        if ($folderid) {
            $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000&\$select=full")->getBody(), true)['value'];

            foreach ($presentations as $presentation) {
                $presentationid = $presentation['Id'];
                $title = trim($presentation['Title']);

                if (!is_dir($path . $title)) {
                    mkdir($path . $title);
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
                        if (!file_exists($path . $title . '/' . $filename)) {
                            // download only if it hasn't been done before
                            file_put_contents($path . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                        }
                        if (filesize($path . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                            // filesize doesn't match! retrying.
                            echo 'Filesize does not match. Error!';
                            file_put_contents($path . '/' . $title . '/' . $filename, file_get_contents($streamurl));
                        }
                        $metadata['sources'][$stream['StreamType']] = $filename;
                    }
                }

                file_put_contents($path . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                // Let's import the data to videos table.

                // Maybe use mediasiteID to ensure that we don't download same thing twice?
                $video = Video::create(array('title' => $metadata['title']));
                $video->title = $metadata['title'];
                $video->length = $metadata['length'];
                $video->tags = implode(', ', $metadata['tags']);
                $video->source1 = array_key_exists('Video1', $metadata['sources']) ? "./storage/mediasite/$type/" . $foldername . '/' . $title . '/' . $metadata['sources']['Video1'] : null;
                $video->source2 = array_key_exists('Video2', $metadata['sources']) ? "./storage/mediasite/$type/" . $foldername . '/' . $title . '/' . $metadata['sources']['Video2'] : null;
                $video->source3 = array_key_exists('Video3', $metadata['sources']) ? "./storage/mediasite/$type/" . $foldername . '/' . $title . '/' . $metadata['sources']['Video3'] : null;
                $video->source4 = array_key_exists('Video4', $metadata['sources']) ? "./storage/mediasite/$type/" . $foldername . '/' . $title . '/' . $metadata['sources']['Video4'] : null;

                if (!$video->source1) {
                    if (!$video->source2) {
                        if (!$video->source3) {
                            if (!$video->source4) {
                                return false;
                            }
                            $video->source3 = $video->source4;
                            $video->source4 = null;
                        }
                        $video->source2 = $video->source3;
                        $video->source3 = null;
                    }
                    $video->source1 = $video->source2;
                    $video->source2 = null;
                }

                $semester = $year = 'Unknown';
                if ($type == 'course') {
                    // We also need to create a course and a category.
                    $term = array();
                    $re = '/([V|H|S]T)(19|20)\d{2}/';
                    preg_match($re, $title, $term, 0, 0);
                    if ($term && $term[0]) {
                        $semester = substr($term[0], 0, 2);
                        $year = substr($term[0], 2, 4);
                    }
                }
                $course = Course::firstOrCreate(array('course_name' => $foldername, 'semester' => $semester, 'year' => $year));
                $course_id = $course->id;
                $video->course_id = $course_id;
                // Dummy for now.
                $video->category_id = 1;
                $video->save();
            }

            return true;
        }
        return false;
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
                $list[] = $url;
                $data['url'] = $list;
                return view('video.test', $data);
            }
        }
    }
}
