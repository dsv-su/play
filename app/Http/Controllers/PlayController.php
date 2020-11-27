<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Jobs\DownloadPresentation;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Services\AuthHandler;
use App\Services\ConfigurationHandler;
use App\UploadHandler;
use App\Video;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PlayController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {

        // If the environment is local
        if (app()->environment('local')) {
            $data['play_user'] = 'För Efternamn';
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

    /**
     * @param Video $video
     * @return Application|Factory|View
     */
    public function player(Video $video)
    {
        //$playlist = Video::where('course_id', $video->course->id)->get();
        //$course = Course::find($video->course->id);
        //return view('player.index', ['video' => $video, 'playlist' => $playlist, 'course' => $course]);

        //$presentation = "./storage/videos/ryan.json";
        $presentation = $video->path;
        $playlist = "/storage/videos/list.json";

        $url = url('/multiplayer') . '?' . http_build_query(['presentation' => $presentation, 'playlist' => $playlist]);
        return Redirect::away($url);

        //return redirect()->route('multiplayer', ['presentation' => $presentation, 'playlist' => $playlist]);
    }

    public function multiplayer()
    {
        return view('player.index');
    }

    public function mediasiteFetch()
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
        $this->getMediasiteFolders($mediasite, $url);
        $this->getMediasitePresentations($mediasite, $url);
        $this->deleteEmptyFolders();
        return redirect()->route('home');
    }

    /**
     * @return Application|Factory|View
     * @throws Exception
     */
    public function mediasite()
    {
        // This requires a correctly symlinked storage folder
        $this->removeDeletedVideos();

        $courses = $users = $recordings = $other = $folders = array();
        $folders = MediasiteFolder::all()->sortBy('name');

        foreach ($folders as $folder) {
            $topparent = $this->getTopParent($folder);
            if ($topparent == $folder) {
                continue;
            }
            if ($topparent->name == 'Courses') {
                $courses[] = array('id' => $folder->mediasite_id, 'name' => $folder->name);
            }
            if ($topparent->name == 'Mediasite Users' && strpos($folder->name, '@su.se') !== false) {
                $users[] = array('id' => $folder->mediasite_id, 'name' => $folder->name);
            }
            if ($topparent->name == 'Recordings') {
                $recordings[] = array('id' => $folder->mediasite_id, 'name' => $folder->name);
            }
        }
        $other = array(
            array('id' => '59a0ee17d4154c6884e5dc98f5a00c8914', 'name' => 'Untitled'),
            array('id' => '73213fc87f634675b9f34456f35115c314', 'name' => 'Recordings')
        );

        return view('home.mediasite', [
            'courses' => $courses,
            'users' => $users,
            'recordings' => $recordings,
            'other' => $other
        ]);
    }

    /**
     * @param MediasiteFolder $folder
     * @return MediasiteFolder
     */
    public function getTopParent(MediasiteFolder $folder)
    {
        if (!$folder->parent) {
            return $folder;
        } else {
            return $this->getTopParent(MediasiteFolder::find($folder->parent));
        }
    }

    /**
     *
     */
    public function deleteEmptyFolders()
    {
        $folders = MediasiteFolder::all();
        foreach ($folders as $folder) {
            if (!$this->findPresentationLeafs($folder)) {
                try {
                    $folder->delete();
                } catch (Exception $e) {
                    abort(500);
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    public function removeDeletedVideos()
    {
        foreach (Video::all() as $video) {
            if (!file_exists($video->source1) && strpos($video->source1, 'http') === false) {
                $mediasite_presentation = $video->mediasite_presentation()->first();
                if ($mediasite_presentation) {
                    $mediasite_presentation->video_id = null;
                    $mediasite_presentation->status = null;
                    $mediasite_presentation->save();
                }
                $video->delete();
            }
        }
    }

    /**
     * @param MediasiteFolder $folder
     * @return bool
     */
    public function findPresentationLeafs(MediasiteFolder $folder)
    {
        if ($folder->presentations()->count()) {
            return true;
        } else {
            $child = MediasiteFolder::where('parent', $folder->id)->first();
            if ($child) {
                return $this->findPresentationLeafs($child);
            } else {
                return false;
            }
        }
    }

    /**
     * @param MediasiteFolder $folder
     * @param $folders
     * @param $subfolders
     */
    public function getSubFolders(MediasiteFolder $folder, $folders, &$subfolders)
    {
        foreach ($folders as $f) {
            if ($f->parent == $folder->id) {
                $subfolders[] = $f;
                $this->getSubFolders($f, $folders, $subfolders);
            }
        }
    }

    /**
     * @param $mediasite
     * @param $url
     * @return array|mixed
     */
    public function getMediasiteFolders($mediasite, $url)
    {
        $folders = array();

        try {
            $folders = json_decode($mediasite->get($url . "/Folders?\$top=1000000")->getBody(), true)['value'];
        } catch (GuzzleException $e) {
            abort(503);
        }

        foreach ($folders as $folder) {
            MediasiteFolder::firstOrCreate(['name' => $folder['Name'], 'mediasite_id' => $folder['Id']]);
        }

        foreach ($folders as $folder) {
            $parentfolder = $folder['ParentFolderId'] ?? null;
            if ($parentfolder) {
                $parent = MediasiteFolder::where('mediasite_id', $parentfolder)->first();
                if ($parent) {
                    $localfolder = MediasiteFolder::where('mediasite_id', $folder['Id'])->firstOrFail();
                    $localfolder->parent = $parent->id;
                    $localfolder->save();
                }
            }
        }

        return $folders;
    }

    /**
     * @param $mediasite
     * @param $url
     */
    public function getMediasitePresentations($mediasite, $url)
    {
        $folders = MediasiteFolder::all();
        foreach ($folders as $folder) {
            try {
                $folderid = $folder->mediasite_id;
                $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000")->getBody(), true)['value'];
                foreach ($presentations as $presentation) {
                    MediasitePresentation::firstOrCreate([
                        'name' => $presentation['Title'],
                        'mediasite_id' => $presentation['Id'],
                        'mediasite_folder_id' => $folder->id
                    ]);
                }
            } catch (GuzzleException $e) {
                abort(503);
            }
        }
    }

    // Not used now. The plan is to call it via ajax when downloading. The call is very eager.

    /**
     * @param MediasiteFolder $folder
     * @param $mediasite
     * @param $url
     * @return string|null
     */
    public function calculateFolderSize(MediasiteFolder $folder, $mediasite, $url)
    {
        $folderid = $folder->id;
        try {
            $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000")->getBody(), true)['value'];
            $foldersize = 0;
            foreach ($presentations as $presentation) {
                $presentationid = $presentation['Id'];
                $streams = json_decode($mediasite->get($url . "/Presentations('$presentationid')/OnDemandContent")->getBody(), true)['value'];
                $presentationlength = 0;
                foreach ($streams as $stream) {
                    $presentationlength += $stream['FileLength'];
                }
                $foldersize += $presentationlength;
            }
            // In Bytes
            return self::bytesToHuman($foldersize);
        } catch (GuzzleException $e) {
            abort(503);
        }
        return null;
    }

    /**
     * @param $bytes
     * @return string
     */
    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1000; $i++) {
            $bytes /= 1000;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function mediasiteUserDownload()
    {
        $folderid = request()->folderid ?? null;
        $username = request()->username ?? null;

        $this->processDownload('user', $username, $folderid);

        $subfolders = array();
        $this->getSubFolders(MediasiteFolder::where('mediasite_id', $folderid)->firstOrFail(), MediasiteFolder::all(), $subfolders);
        foreach ($subfolders as $subfolder) {
            $this->processDownload('user', $username . '/' . $subfolder->name, $subfolder->mediasite_id);
        }

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function mediasiteCourseDownload()
    {
        $folderid = request()->folderid ?? null;
        $coursename = request()->coursename ?? null;

        $this->processDownload('course', $coursename, $folderid);

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function mediasiteRecordingDownload()
    {
        $folderid = request()->folderid ?? null;
        $foldername = request()->foldername ?? null;

        $this->processDownload('various', $foldername, $folderid);

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function mediasiteOtherDownload()
    {
        $folderid = request()->folderid ?? null;
        $foldername = request()->foldername ?? null;

        $this->processDownload('other', $foldername, $folderid);

        return redirect()->route('home');
    }

    /**
     * @param $type
     * @param $foldername
     * @param $folderid
     * @return bool
     * @throws Exception
     */
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
            $presentations = MediasitePresentation::where('mediasite_folder_id', MediasiteFolder::where('mediasite_id', $folderid)->firstOrFail()->id)->get();
            foreach ($presentations as $presentation) {
                DownloadPresentation::dispatch($presentation, $type, $path, $foldername);
                /*
                try {
                    $presentationid = $presentation['Id'];

                    // Check if it's already downloaded
                    $locallysaved = MediasitePresentation::where('mediasite_id', $presentationid)
                        ->where('status', 1)->first();
                    // We skip only if mediasite presentation has a correct pointer to a local video
                    if ($locallysaved && $locallysaved->video_id) {
                        continue;
                    }

                    $title = trim($presentation['Title']);

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
                            if (!file_exists($path . $title . '/' . $filename)) {
                                // download only if it hasn't been done before
                                if (!is_dir($path . $title)) {
                                    mkdir($path . $title);
                                }
                                $client->request('GET', $streamurl, ['sink' => $path . '/' . $title . '/' . $filename]);
                            }
                            if (filesize($path . '/' . $title . '/' . $filename) != $stream['FileLength']) {
                                // filesize doesn't match! retrying.
                                echo 'Filesize does not match. Error!';
                                $client->request('GET', $streamurl, ['sink' => $path . '/' . $title . '/' . $filename]);
                            }
                            $metadata['sources'][$stream['StreamType']] = $filename;
                        }
                    }

                    if ($emptystreams) {
                        return false;
                    }

                    // Save metadata json
                    file_put_contents($path . '/' . $title . '/data.json', json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

                    // Let's import the data to videos table.
                    // Maybe use mediasiteID to ensure that we don't download same thing twice?
                    $video = new Video;
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

                    // Dummy for now. We don't have categories
                    $video->category_id = 1;
                    $video->save();

                    //Update presentsation status
                    $localpresentation = MediasitePresentation::where('mediasite_id', $presentationid)->firstOrFail();
                    $localpresentation->status = 1;
                    $localpresentation->video_id = $video->id;
                    $localpresentation->save();

                    //Make sure to remove videos that are unattached (without relation to mediasite_presentation)
                    $othervideos = Video::where('source1', $video->source1)->get();
                    if ($othervideos->count() > 1) {
                        foreach ($othervideos as $othervideo) {
                            if (!$othervideo->mediasite_presentation()->count()) {
                                $othervideo->delete();
                            }
                        }
                    }
                } catch (GuzzleException $e) {
                    dd($e);
                }
                */
            }

            return true;
        }
        return false;
    }

    /**
     * @return Application|Factory|View
     */
    public function upload()
    {
        $data['upload'] = 0;
        return view('video.test', $data);
    }

    /**
     * @param Request $request
     * @return false|Application|Factory|View
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = Storage::putFileAs('public', $request->file('file'), 'upload.txt');
            if ($request->file('file')->extension() == 'txt') {
                //Multiple streams
                $streams = new UploadHandler();
                $streams = $streams->getUpload($path);
                $x = 1;
                $list = array();
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
        return false;
    }

    public function manage()
    {
        return view('home.manage', ['videos' => Video::all()]);
    }
}
