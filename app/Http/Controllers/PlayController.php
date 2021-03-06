<?php

namespace App\Http\Controllers;

use App\Course;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Presenter;
use App\Services\AuthHandler;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Notify\PlayStoreNotify;
use App\System;
use App\Tag;
use App\UploadHandler;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use App\VideoStat;
use App\VideoTag;
use Carbon\Carbon;
use Exception;
use File;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PlayController extends Controller
{
    /**
     *  For testing purposes. Should be refactored before production.
     *
     */

    public function index()
    {
        if (!System::find(1)) {
            return redirect()->action([SystemController::class, 'start']);
        }
        //For testing
        if (in_array(app()->make('play_role'), ['Student1', 'Student2', 'Student3'])) {
            if (app()->make('play_role') == 'Student1') {
                $courses = [6761, 6837, 6703, 6839, 6708, 6838, 6769];
            } elseif (app()->make('play_role') == 'Student2') {
                $courses = [6817, 6644, 6737, 6661, 6816, 6835, 6780, 6626, 6656, 6748, 6604, 6684, 6819, 6595];
            } elseif (app()->make('play_role') == 'Student3') {
                $courses = [6798, 6799, 6760, 6778, 6828, 6796, 6719, 6720];
            }
            $data['permissions'] = VideoPermission::all();
            $data['latest'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses)->take(24);
            })->get();

        } // end testing
        elseif (app()->make('play_role') == 'Student') {
            $data['permissions'] = VideoPermission::all();
            $daisy = new DaisyIntegration();
            $courses = $daisy->getActiveStudentCourses(app()->make('play_username'));
            $data['latest'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses)->take(24);
            })->get();
        } //If user is Employee
        elseif (App::environment('production') and (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')) {
            $data['permissions'] = VideoPermission::all();
            $daisy = new DaisyIntegration();
            $courses = $daisy->getActiveEmployeeCourses(app()->make('play_username'));
            $data['latest'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses);
            })->get();
        } else {
            //If user is Admin
            $data['search'] = 0;
            $data['latest'] = Video::with('category', 'video_course.course')->latest('creation')->take(24)->get();
            $data['permissions'] = VideoPermission::all();
            //$data['categories'] = Category::all();
            //-> Most viewed
            $vid = DB::table('videos')
                ->select(['video_id', DB::raw('MAX(playback) AS playback')])
                ->whereNotNull('playback')
                ->join('video_stats', 'videos.id', '=', 'video_stats.video_id')
                ->groupBy('video_id')
                ->take(5)->get();

            $most_viewed = collect($vid)->map(function ($item) {
                return $item->video_id;
            });
            $data['most_viewed'] = Video::with('category', 'video_course.course')->whereIn('id', $most_viewed)->take(24)->get();
            //-> Most downloaded
            $vid = DB::table('videos')
                ->select(['video_id', DB::raw('MAX(download) AS download')])
                ->whereNotNull('download')
                ->join('video_stats', 'videos.id', '=', 'video_stats.video_id')
                ->groupBy('video_id')
                ->take(5)->get();

            $most_down = collect($vid)->map(function ($item) {
                return $item->video_id;
            });
            $data['most_downloaded'] = Video::with('category', 'video_course.course')->whereIn('id', $most_down)->take(24)->get();
        }

        //All courses (tab 2)
        $data['all'] = Video::with('category', 'video_course.course')->latest('creation')->take(24)->get();

        return view('home.index', $data);
    }

    /**
     * @return Application|Factory|View
     */
    public function myVideos()
    {
        //--> This should be refactored
        $data['mycourses'] = $this->getUserCoursesWithVideos($_SERVER['eppn'] ?? 'dsv-dev@su.se');
        if (!$data['mycourses']->count()) {
            abort(404);
        } else {
            $data['hasmycourses'] = ($this->getUserCoursesWithVideos($_SERVER['eppn'] ?? 'dsv-dev@su.se')->count() > 0);
        }
        $data['tags'] = $this->getFilterableItems($data['mycourses']);
        return view('home.my', $data);
    }

    public function myVideosFilter(Request $request)
    {
        $mycourses = $this->getUserCoursesWithVideos($_SERVER['eppn'] ?? 'dsv-dev@su.se');
        $tags = $request->tag_list ?? array();
        $courses = $request->course_list ?? array();
        $searchsplit = $request->text ? preg_split('/\s+/', strtolower($request->text)) : array();
        $datestart = $request->datestart ?? null;
        $dateend = $request->dateend ?? null;

        foreach ($mycourses as $keycourse => $course) {
            if ($courses && !in_array($course->id, $courses)) {
                unset($mycourses[$keycourse]);
                continue;
            }
            foreach ($course->myvideos as $keyvideo => $video) {
                if ($datestart && $video->getPresentationDate() && $datestart > $video->getPresentationDate()) {
                    unset($course->myvideos[$keyvideo]);
                    continue;
                }
                if ($dateend && $video->getPresentationDate() && $dateend < $video->getPresentationDate()) {
                    unset($course->myvideos[$keyvideo]);
                    continue;
                }
                foreach ($searchsplit as $search) {
                    if (!str_contains(strtolower($video->title), $search)) {
                        unset($course->myvideos[$keyvideo]);
                        continue;
                    }
                }
                foreach ($tags as $tag_id) {
                    if (!$video->has_tag($tag_id)) {
                        unset($course->myvideos[$keyvideo]);
                    }
                }
            }
        }

        return view('home.videolist', compact('mycourses'));
    }

    private function getUserCoursesWithVideos($username)
    {
        // Get all videos where the current user is a presenter
        $mycourses = Course::all();
        foreach ($mycourses as $key => $course) {
            $course->myvideos = $course->userVideos(Presenter::where('username', $username)->first());
            if ($course->myvideos->isEmpty()) {
                unset($mycourses[$key]);
            }
        }
        return $mycourses;
    }

    public function getFilterableItems($courseswithvideos)
    {
        $tags = collect();
        foreach ($courseswithvideos as $coursevideos) {
            foreach ($coursevideos->myvideos as $video) {
                if (!$video->tags()->isEmpty()) {
                    foreach ($video->tags() as $tag) {
                        if (!$tags->contains('id', $tag->id)) {
                            $tags->add($tag);
                        }
                    }
                }
            }
        }
        return $tags;
    }

    public
    function mediasiteFetch(): RedirectResponse
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
    public
    function mediasite()
    {
        // This requires a correctly symlinked storage folder
        // $this->removeDeletedVideos();

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
            'mediasitecourses' => $courses,
            'users' => $users,
            'recordings' => $recordings,
            'other' => $other,
            'hasmycourses' => $this->getUserCoursesWithVideos($_SERVER['eppn'] ?? 'dsv-dev@su.se')->count() > 0
        ]);
    }

    /**
     * @param MediasiteFolder $folder
     * @return MediasiteFolder
     */
    public
    function getTopParent(MediasiteFolder $folder): MediasiteFolder
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
    public
    function deleteEmptyFolders()
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
    public
    function removeDeletedVideos()
    {
        foreach (Video::all() as $video) {
            $sources = json_decode($video->presentation)->sources;
            $delete = true;
            foreach ($sources as $source) {
                if (file_exists($source->video) || strpos($source->video, 'http') !== false) {
                    $delete = false;
                }
            }
            if ($delete) {
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
    public
    function findPresentationLeafs(MediasiteFolder $folder): bool
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
    public
    function getSubFolders(MediasiteFolder $folder, $folders, &$subfolders)
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
    public
    function getMediasiteFolders($mediasite, $url): array
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
    public
    function getMediasitePresentations($mediasite, $url)
    {
        $folders = MediasiteFolder::all();
        foreach ($folders as $folder) {
            try {
                $folderid = $folder->mediasite_id;
                $presentations = json_decode($mediasite->get($url . "/Folders('$folderid')/Presentations?\$top=100000")->getBody(), true)['value'];
                foreach ($presentations as $presentation) {
                    MediasitePresentation::firstOrCreate([
                        'title' => $presentation['Title'],
                        'id' => $presentation['Id'],
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
    public
    function calculateFolderSize(MediasiteFolder $folder, $mediasite, $url): ?string
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
    public
    static function bytesToHuman($bytes): string
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
    public
    function mediasiteUserDownload(): RedirectResponse
    {
        $folderid = request()->user ?? null;
        $dates = explode(' - ', request('daterange'));
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);
        $this->processDownload('user', $folderid, $start ?? 0, $end ?? 32472226800);

        $subfolders = array();
        $this->getSubFolders(MediasiteFolder::where('mediasite_id', $folderid)->firstOrFail(), MediasiteFolder::all(), $subfolders);
        foreach ($subfolders as $subfolder) {
            $this->processDownload('user', $subfolder->mediasite_id, $start ?? 0, $end ?? 32472226800);
        }

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public
    function mediasiteCourseDownload(): RedirectResponse
    {
        $folderid = request()->course ?? null;
        $designation = request()->designation ?? null;
        $dates = explode(' - ', request('daterange'));
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);
        $this->processDownload('course', $folderid, $designation, $start ?? 0, $end ?? 32472226800);

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public
    function mediasiteRecordingDownload(): RedirectResponse
    {
        $folderid = request()->recording ?? null;
        $dates = explode(' - ', request('daterange'));
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);

        $this->processDownload('various', $folderid, $start ?? 0, $end ?? 32472226800);

        return redirect()->route('home');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public
    function mediasiteOtherDownload(): RedirectResponse
    {
        $folderid = request()->other ?? null;
        $dates = explode(' - ', request('daterange'));
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);
        $this->processDownload('other', $folderid, $start ?? 0, $end ?? 32472226800);

        return redirect()->route('home');
    }

    /**
     * @param $type
     * @param $foldername
     * @param $folderid
     * @return bool
     * @throws Exception
     */
    public
    function processDownload($type, $folderid, $designation = null, $start = null, $end = null): bool
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

        if ($folderid) {
            $presentations = MediasitePresentation::where('mediasite_folder_id', MediasiteFolder::where('mediasite_id', $folderid)->firstOrFail()->id)->get();
            foreach ($presentations as $presentation) {
                try {
                    $presentationid = $presentation->id;
                    $mediasite_presentation = json_decode($mediasite->get($url . "/Presentations('$presentationid')?\$select=full")->getBody(), true);

                    if ($start || $end) {
                        $recorded = strtotime($mediasite_presentation['RecordDate']);
                        if ($recorded < $start->timestamp || $recorded > $end->timestamp) {
                            continue;
                        }
                    }

                    // Now let's create a json with all relevant metadata
                    $metadata = array(
                        'mediasiteid' => $mediasite_presentation['Id'],
                        'title' => trim($mediasite_presentation['Title']),
                        'description' => $mediasite_presentation['Description'],
                        'recorded' => $mediasite_presentation['RecordDate'],
                        'duration' => $mediasite_presentation['Duration'],
                        'owner' => $mediasite_presentation['Owner'],
                        'tags' => $mediasite_presentation['TagList']
                    );

                    // Presenters
                    $users = array();
                    try {
                        $users = json_decode($mediasite->get($url . "/UserProfiles")->getBody(), true)['value'];
                    } catch (GuzzleException $e) {
                        abort(503);
                    }

                    $presenters = array();
                    try {
                        $presenters = json_decode($mediasite->get($url . "/Presentations('$presentationid')/Presenters")->getBody(), true)['value'];
                    } catch (GuzzleException $e) {
                        abort(503);
                    }

                    foreach ($presenters as $presenter) {
                        $array = array_filter($users, function ($user) use ($presenter) {
                            return $user['DisplayName'] == $presenter['DisplayName'];
                        });
                        $found = array_pop($array);
                        if ($found) {
                            $metadata['presenters'][] = $found['UserName'];
                        }
                    }

                    $streams = array();
                    try {
                        $streams = json_decode($mediasite->get($url . "/Presentations('$presentationid')/OnDemandContent")->getBody(), true)['value'];
                    } catch (GuzzleException $e) {
                        abort(503);
                    }

                    $thumbs = array();
                    try {
                        $thumbs = json_decode($mediasite->get($url . "/Presentations('$presentationid')/ThumbnailContent")->getBody(), true)['value'];
                    } catch (GuzzleException $e) {
                        abort(503);
                    }

                    $emptystreams = true;
                    foreach ($streams as $key => $stream) {
                        $filename = $stream['FileNameWithExtension'];
                        // Skip zero length
                        if ($stream['Length'] > 0) {
                            $emptystreams = false;
                            $streamurl = "https://mediasite-media.dsv.su.se/SmoothStreaming/OnDemand/MP4Video/$filename";
                            $thumb = array_filter($thumbs, function ($t) use ($stream) {
                                return $t['StreamType'] == $stream['StreamType'];
                            });
                            $client = new Client();
                            $metadata['sources'][] = array(
                                'video' => $streamurl,
                                'poster' => array_pop($thumb)['ThumbnailUrl'],
                                'playAudio' => $key ? false : true
                            );
                        }
                    }
                    if ($emptystreams) {
                        return false;
                    }

                    //$p = MediasitePresentation::where('mediasite_id', $presentationid)->first();
                    $presentation->status = 'request download';
                    $presentation->title = $metadata['title'];
                    $presentation->presenters = $metadata['presenters'] ?? [];
                    $presentation->tags = $metadata['tags'] ?? [];
                    //$p->description = $metadata['description'];
                    //$p->courses = [];
                    $presentationthumb = array_filter($thumbs, function ($t) {
                        return $t['StreamType'] == 'Presentation';
                    });
                    $presentation->thumb = array_pop($presentationthumb)['ThumbnailUrl'];
                    $presentation->created = strtotime($metadata['recorded']);
                    $presentation->duration = $metadata['duration'];
                    $presentation->sources = $metadata['sources'];

                    $semester = $year = '';
                    if ($type == 'course') {
                        // We also need to create a course and a category.
                        //$designation = explode(' - ', $foldername)[0] ?? $foldername;
                        $presentation->courses = array($designation);
                        $re = '/([V|H|S]T)(19|20)\d{2}/';
                        preg_match($re, $metadata['title'], $term, 0, 0);
                        if ($term && $term[0]) {
                            //  $semester = substr($term[0], 0, 2);
                            //  $year = substr($term[0], 2, 4);
                        }
                    }

                    //dd($p);

                    $notify = new PlayStoreNotify($presentation);
                    $notify->sendSuccess('mediasite');

                    //return true;
                } catch (GuzzleException $e) {
                    report($e);
                }

                //DownloadPresentation::dispatch($presentation, $type, $path, $foldername);
            }

            return true;
        }
        return false;
    }

    /**
     * @return Application|Factory|View
     */
    public
    function upload()
    {
        $data['upload'] = 0;
        return view('video.test', $data);
    }

    /**
     * @param Request $request
     * @return Factory|false|Application|\Illuminate\Contracts\View\View
     */
    public
    function store(Request $request)
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


    public function deleteVideoAjax(Request $request): JsonResponse
    {
        /*** This method should be refactored
         ***/

        $video = Video::find($request->video_id);
        $folder = dirname($video->source1);
        if (is_dir($folder)) {
            $files = glob($folder . '/*');
            // Loop through the file list
            foreach ($files as $file) {
                // Check for file
                if (is_file($file)) {
                    // Use unlink function to delete the file.
                    unlink($file);
                }
            }
            rmdir($folder);
        }

        /*if ($video->mediasite_presentation) {
            $video->mediasite_presentation->video_id = null;
            $video->mediasite_presentation->status = null;
            $video->mediasite_presentation->save();
        }*/
        foreach ($video->video_course as $vc) {
            VideoCourse::findOrFail($vc->id)->delete();
        }

        foreach ($video->video_tag as $vt) {
            VideoTag::findOrFail($vt->id)->delete();
        }


        foreach ($video->video_presenter as $vp) {
            VideoPresenter::findOrFail($vp->id)->delete();
        }
        foreach ($video->video_stat as $vp) {
            VideoStat::where('video_id', $request->video_id)->firstOrFail()->delete();
        }

        //Remove permissions for video
        VideoPermission::where('video_id', $request->video_id)->firstOrFail()->delete();
        //Remove stats for video
        VideoStat::where('video_id', $request->video_id)->firstOrFail()->delete();

        try {
            $video->delete();
        } catch (Exception $e) {
            report($e);
            return Response()->json([
                'message' => 'Error',
            ]);
        }

        //Send Delete notification -> when this is active
        /*$notify = new PlayStoreNotify($video);
        $notify->sendDelete();
        return back()->with(['message' => 'Presentationen har raderats']);*/

        return Response()->json(['message' => 'Video deleted']);
    }

    public
    function editVideoAjax(Request $request): JsonResponse
    {
        try {
            $video = Video::find($request->video_id);
            $courses = json_decode($request->course_ids);
            $tags = json_decode($request->tag_ids);

            if (!empty($tags)) {
                VideoTag::where('video_id', $video->id)->delete();
                foreach ($tags as $tag) {
                    VideoTag::updateOrCreate([
                        'video_id' => $video->id,
                        'tag_id' => $tag,
                    ]);
                }
            }

            if (!empty($courses)) {
                VideoCourse::where('video_id', $video->id)->delete();
                foreach ($courses as $course) {
                    VideoCourse::updateOrCreate([
                        'video_id' => $video->id,
                        'course_id' => $course,
                    ]);
                }
            }

            $video->category_id = $request->category_id;
            $video->save();
            $tagnames = '';
            $coursenames = '';
            foreach ($video->video_course as $vc) {
                $coursenames .= '<a href="/course/' . $vc->course_id . '" class="badge badge-primary">' . Course::find($vc->course_id)->designation . '</a>';
            }
            foreach ($video->video_tag as $vt) {
                $tagnames .= '<a href="/tag/' . $vt->tag_id . '" class="badge badge-secondary">' . Tag::find($vt->tag_id)->name . '</a>';
            }
            return Response()->json([
                'message' => 'Changes saved',
                'category' => '<span class="badge badge-light">' . $video->category->category_name . '</span>',
                'courses' => $coursenames,
                'tags' => $tagnames
            ]);
        } catch (Exception $e) {
            report($e);
            return Response()->json([
                'message' => 'Error.',
            ]);
        }
    }
}
