<?php

namespace App\Http\Controllers;

use App\Course;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Presenter;
use App\Services\AuthHandler;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Notify\PlayStoreNotify;
use App\Stream;
use App\StreamResolution;
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
     *  Home Page
     *  Generated Presentations for the Home Page.
     *  The "Fake" students emulation should be removed prior to launch.
     */

    public function index()
    {
        if (!System::find(1)) {
            return redirect()->action([SystemController::class, 'start']);
        }
        //For testing
        $daisy = new DaisyIntegration();
        $data['permissions'] = VideoPermission::all();

        //Fake students
        if (in_array(app()->make('play_role'), ['Student1', 'Student2', 'Student3'])) {
            if (app()->make('play_role') == 'Student1') {
                $courses = [6442, 6841, 6761, 6837, 6703, 6839, 6708, 6838, 6769];
            } elseif (app()->make('play_role') == 'Student2') {
                $courses = [6817, 6644, 6737, 6661, 6816, 6835, 6780, 6626, 6656, 6748, 6604, 6684, 6819, 6595];
            } elseif (app()->make('play_role') == 'Student3') {
                $courses = [6798, 6799, 6760, 6778, 6828, 6796, 6719, 6720];
            }
            $data['my'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($courses) {
                return $query->whereIn('course_id', $courses)->take(24);
            })->get();

            //All courses (tab 3)
            $data['active'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($daisy) {
                return $query->whereIn('course_id', $daisy->getActiveCourses());
            })->get();
            $data['latest'] = Video::with('category', 'video_course.course')->where('visability', true)->latest('creation')->get();

        } // end testing

        //User is Student
        elseif (App::environment('production') and app()->make('play_role') == 'Student') {
            $courses = $daisy->getActiveStudentCourses(app()->make('play_username'));
            if ($courses) {
                $data['my'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($courses) {
                    return $query->whereIn('course_id', $courses)->take(24);
                })->get();
            }

            //All courses (tab 3)
            $data['active'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($daisy) {
                return $query->whereIn('course_id', $daisy->getActiveCourses());
            })->get();
            $data['latest'] = Video::with('category', 'video_course.course')->where('visability', true)->latest('creation')->get();

        } //If user is Employee
        elseif (App::environment('production') and (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Staff')) {
            $courses = $daisy->getActiveEmployeeCourses(app()->make('play_username'));
            if ($courses) {
                $data['my'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($courses) {
                    return $query->whereIn('course_id', $courses);
                })->get();
            }

            //All courses (tab 3)
            $data['active'] = Video::with('video_course.course')->where('visability', true)->whereHas('video_course.course', function ($query) use ($daisy) {
                return $query->whereIn('course_id', $daisy->getActiveCourses());
            })->get();
            $data['latest'] = Video::with('category', 'video_course.course')->where('visability', true)->latest('creation')->get();
        } else {
            //If user is Admin
            $data['search'] = 0;

            //All courses (tab 3)
            $data['active'] = Video::with('video_course.course')->whereHas('video_course.course', function ($query) use ($daisy) {
                return $query->whereIn('course_id', $daisy->getActiveCourses());
            })->get();
            $data['latest'] = Video::with('category', 'video_course.course')->latest('creation')->get();

            if (app()->make('play_role') != 'Administrator') {
                $data['active'] = $data['active']->filter(function ($video) {
                    return $video->visability;
                });
                $data['latest'] = $data['latest']->filter(function ($video) {
                    return $video->visability;
                });
            }
        }


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
                    if ($presentation['Status'] == 'Viewable') {
                        $mp = MediasitePresentation::find($presentation['Id']);
                        if (!$mp) {
                            MediasitePresentation::create([
                                'title' => $presentation['Title'],
                                'id' => $presentation['Id'],
                                'mediasite_folder_id' => $folder->id
                            ]);
                        } else {
                            $mp->title = $presentation['Title'];
                            $mp->mediasite_folder_id = $folder->id;
                            $mp->save();
                        }
                    } else {
                        MediasitePresentation::where(['id' => $presentation['Id']])->delete();
                    }
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

    public function prefetchCourseDownload(): JsonResponse
    {
        $folderid = request()->course ?? null;
        $dates = explode(' - ', request('daterange'));
        $start = Carbon::createFromFormat('d/m/Y', $dates[0]);
        $end = Carbon::createFromFormat('d/m/Y', $dates[1]);
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

        $presentations = MediasitePresentation::where('mediasite_folder_id', MediasiteFolder::where('mediasite_id', $folderid)->firstOrFail()->id)->get();
        $todownload = [];
        foreach ($presentations as $presentation) {
            $presentationid = $presentation->id;
            $mediasite_presentation = json_decode($mediasite->get($url . "/Presentations('$presentationid')?\$select=full")->getBody(), true);

            if ($start || $end) {
                $recorded = strtotime($mediasite_presentation['RecordDate']);
                if ($recorded < $start->timestamp || $recorded > $end->timestamp + 3600) {
                    continue;
                }
            }
            $todownload[] = ['name' => $mediasite_presentation['Title'], 'id' => $mediasite_presentation['Id']];
        }
        return Response()->json(['presentations' => json_encode($todownload)]);
    }

    /**
     * @param $type
     * @param $folderid
     * @param null $designation
     * @param null $start
     * @param null $end
     * @return bool
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
                        if ($recorded < $start->timestamp || $recorded > $end->timestamp + 3600) {
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
                            $metadata['sources'][] = array(
                                'video' => $streamurl,
                                'poster' => array_pop($thumb)['ThumbnailUrl'],
                                'playAudio' => !$key
                            );
                        }
                    }
                    if ($emptystreams) {
                        return false;
                    }

                    $slides = array();
                    try {
                        $slides = json_decode($mediasite->get($mediasite_presentation['SlideContent@odata.navigationLinkUrl'])->getBody(), true)['value'];
                    } catch (GuzzleException $e) {
                        report($e);
                    }

                    foreach ($slides as $slide) {
                        if (!$slide['IsGeneratedFromVideoStream']) {
                            $mediasiteid = substr(substr_replace(substr_replace(substr_replace(substr_replace($slide['Id'], '-', 20, 0), '-', 16, 0), '-', 12, 0), '-', 8, 0), 0, -2);
                            $blobs = DB::connection('notmediasite')->select("select * from Timecodes where id = '$mediasiteid'")[0]->datablob;
                            $xml = simplexml_load_string($blobs);
                            $json = json_encode($xml);
                            $array = json_decode($json, TRUE);
                            for ($i = 1; $i < $slide['Length'] + 1; $i++) {
                                $filename = "slide_" . str_pad($i, 4, "0", STR_PAD_LEFT) . ".jpg";
                                $slideurl = "https://play2.dsv.su.se/FileServer/" . $slide['ContentServerId'] . "/Presentation/" . $slide['ParentResourceId'] . "/" . $filename;
                                $metadata['slides'][] = ['url' => $slideurl, 'duration' => isset($array['Slides']['SlideEntry'][$i - 1]) ? $array['Slides']['SlideEntry'][$i - 1]['Time'] : $array['Slides']['SlideEntry']['Time']];
                            }
                        }
                    }

                    //$p = MediasitePresentation::where('mediasite_id', $presentationid)->first();
                    $presentation->status = 'request download';
                    $presentation->title = $metadata['title'];
                    $presentation->description = $metadata['description'];
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
                    if (isset($metadata['slides'])) {
                        $presentation->slides = $metadata['slides'];
                    }

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

                    $notify = new PlayStoreNotify($presentation);
                    $notify->sendSuccess('mediasite');
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

        //Start transaction
        DB::beginTransaction();

        try {
            if ($video->origin == 'mediasite') {
                foreach (MediasitePresentation::where('video_id', $video->id)->get() as $mp) {
                    $mp->status = null;
                    $mp->video_id = null;
                    $mp->save();
                }
            }
            VideoCourse::where('video_id', $video->id)->delete();
            VideoTag::where('video_id', $video->id)->delete();
            VideoPresenter::where('video_id', $video->id)->delete();
            VideoPermission::where('video_id', $request->video_id)->delete();
            VideoStat::where('video_id', $request->video_id)->delete();
            $streams = Stream::where('video_id', $video->id)->get();
            foreach ($streams as $stream) {
                StreamResolution::where('stream_id', $stream->id)->delete();
                $stream->delete();
            }
            $video->delete();
        } catch (Exception $e) {
            report($e);
            DB::rollback(); // Something went wrong
            return Response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        DB::commit();   // Successfully removed

        //Send Delete notification -> when this is active
        $notify = new PlayStoreNotify($video);
        $notify->sendDelete();
        return Response()->json(['message' => 'Presentationen har raderats']);

        //return Response()->json(['message' => 'Video deleted']);
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
