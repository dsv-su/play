<?php

namespace App\Http\Controllers;

use App\AdminHandler;
use App\Course;
use App\ManualPresentation;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Permission;
use App\Presentation;
use App\Services\Cattura\CheckCatturaRecorderStatus;
use App\Services\Notify\PlayStoreNotify;
use App\Video;
use App\VideoPermission;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('play-admin')->except('emulateUser');
        //New admin2
        $this->middleware('playauth:api');
        $this->middleware('play-store-status:api');
        $this->middleware('daisy-status:api');
        $this->middleware('admin-stats');

    }

    public function flush()
    {
        Cache::flush();
        return redirect()->action([AdminController::class, 'admin']);
    }

    public function admin()
    {
        //Cache store
        $seconds = 180;
        //Uploads
        $data['init_uploads'] = Cache::remember('init_uploads', $seconds, function () {
            return ManualPresentation::where('status', 'init')->count();
        });
        $data['pending_uploads'] = Cache::remember('pending_uploads', $seconds, function () {
            return ManualPresentation::where('status', 'pending')->count();
        });
        $data['stored_uploads'] = Cache::remember('stored_uploads', $seconds, function () {
            return ManualPresentation::where('status', 'stored')->count();
        });

        //Downloads
        $data['requested_downloads'] = Cache::remember('requested_downloads', $seconds, function () {
            return Presentation::where('status', 'request download')->count();
        });
        $data['stored_downloads'] = Cache::remember('stored_downloads', $seconds, function () {
            return Presentation::where('status', 'stored')->count();
        });

        //Mediasite
        $data['stats_mediasite'] = Cache::remember('stats_mediasite', $seconds, function () {
            return Video::where('origin', 'mediasite')->count();
        });
        $data['stats_mediasite_folders'] = Cache::remember('stats_mediasite_folders', $seconds, function () {
            return MediasiteFolder::count();
        });

        //Cattura
        $data['stats_cattura'] = Cache::remember('stats_cattura', $seconds, function () {
            return Video::where('origin', 'cattura')->count();
        });

        //Manually uploaded
        $data['stats_manual'] = Cache::remember('stats_manual', $seconds, function () {
            return Video::where('origin', 'manual')->count();
        });

        //Permissions
        $data['stats_permissions'] = Cache::remember('stats_permissions', $seconds, function () {
            return Permission::count();
        });
        $data['stats_permissions_dsv'] = Cache::remember('stats_permissions_dsv', $seconds, function () {
            return VideoPermission::with('permission')->where('permission_id', 1)->count();
        });
        $data['stats_permissions_staff'] = Cache::remember('stats_permissions_staff', $seconds, function () {
            return VideoPermission::with('permission')->where('permission_id', 2)->count();
        });
        $data['stats_permissions_private'] = Cache::remember('stats_permissions_private', $seconds, function () {
            return VideoPermission::with('permission')->where('permission_id', 3)->count();
        });
        $data['stats_permissions_public'] = Cache::remember('stats_permissions_public', $seconds, function () {
            return VideoPermission::with('permission')->where('permission_id', 4)->count();
        });

        //->
        /*
                    $data['permissions'] = VideoPermission::all();
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
                    */
        //<-
        // Cattura
        $store = new CheckCatturaRecorderStatus();

        $file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($file)) {
            $file = base_path() . '/systemconfig/play.ini.example';
        }
        $system_config = parse_ini_file($file, true);

        foreach($system_config['recorders'] as $key => $system) {
            $check = $store->call($system,'api/1/status?since=');
            $data['cattura'][] = [
                'recorder' => $key,
                'status' => $check['capture']['state'],
                'url' => $system
            ];
        }
        //Courses
        $data['courses_2015'] = Course::where('year', 2015)->count();
        $data['courses_2016'] = Course::where('year', 2016)->count();
        $data['courses_2017'] = Course::where('year', 2017)->count();
        $data['courses_2018'] = Course::where('year', 2018)->count();
        $data['courses_2019'] = Course::where('year', 2019)->count();
        $data['courses_2020'] = Course::where('year', 2020)->count();
        $data['courses_2021'] = Course::where('year', 2021)->count();
        $data['courses_2022'] = Course::where('year', 2022)->count();

        return view('admin.admin', $data);
    }

    public function uploads()
    {
        $data['manual_presentations'] = ManualPresentation::all();
        return view('admin.partials.uploads', $data);
    }

    public function downloads()
    {
        $data['presentations'] = Presentation::all();
        return view('admin.partials.downloads', $data);
    }

    public function mediasite()
    {
        $data['mediasite_presentations'] = MediasitePresentation::all()->where('status', '<>' ,null);
        $data['mediasite_folders'] = MediasiteFolder::all();
        return view('admin.partials.mediasite', $data);
    }

    public function videopermission()
    {
        $data['permissions'] = VideoPermission::with('permission')->get();
        return view('admin.partials.videopermissions', $data);
    }

    public function emulateUser(Request $request)
    {
        if(!$request->server('REMOTE_USER')) {
            //No Shib_Session_ID
            if($request->role == 'Administrator'){
                AdminHandler::updateOrCreate(['Shib_Session_ID' => '9999'],['override' => false]);
            } else {
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => '9999']);
                $adminhandler->override = true;
                $adminhandler->role = $request->role;
                $adminhandler->save();
                if (in_array($adminhandler->role, [ 'Student','Student1', 'Student2', 'Student3'])) {
                    return redirect()->route('home');
                }

            }

        }
        else {
            //Has Shib_Session_ID
            if($request->role == 'Administrator'){
                AdminHandler::updateOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')], ['override' => false]);
            } else {
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')]);
                $adminhandler->override = true;
                $adminhandler->role = $request->role;
                $adminhandler->save();
            }
        }

        return redirect()->back();
    }

    public function addPermission()
    {
        $permissions = Permission::all();
        $modify = 0;

        return view('admin.permission.form', compact('permissions', 'modify'));
    }
    public function adminNewPermission(Request $request)
    {
        if ($request->isMethod('post')) {

            //Validation
            $this->validate($request, [
                'permission' => 'required',
                'entitlement' => 'required'
            ]);
            if($request->modify == 0){
                Permission::updateOrCreate(
                    ['scope' => $request->permission],
                    ['entitlement' => $request->entitlement]
                );
            }
            else {
                $permission = Permission::find($request->pid);
                $permission->scope = $request->permission;
                $permission->entitlement = $request->entitlement;
                $permission->save();
                return redirect()->route('add_permission')->with(['message' => 'The permissions group has been updated']);
            }


            }
        return back()->with(['message' => 'A new permission group has been created']);
    }

    public function modifyPermission(Permission $permission)
    {
        $modify = 1;
        $thispermission = $permission;
        $permissions = Permission::all();

        return view('admin.permission.form', compact('permissions', 'thispermission', 'modify'));
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();

        return back()->with(['message' => 'The permissiongroup has been deleted']);
    }

    public function admin_erase($id)
    {
        $manual = ManualPresentation::find($id);
        Storage::disk('public')->deleteDirectory($manual->local);
        ManualPresentation::destroy($id);
        return back()->withInput();
    }

    public function admin_upload_notify_fail($id)
    {
        $presentation = ManualPresentation::find($id);
        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendFail('manual');

        return back()->withInput();
    }

    public function admin_download_notify_resend($id)
    {
        $presentation = Presentation::find($id);

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('update');

        return back()->withInput();
    }

    public function admin_unregister($id): RedirectResponse
    {
        ManualPresentation::destroy($id);
        return back()->withInput();
    }

    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sftp']['uri'];
    }

    public function destroy_upload($id)
    {
        /************************
         * Dev testing
         * ->to be removed
         */
        //Remove temp storage in dev
        Storage::disk('public')->deleteDirectory($id);
        $data['manual_presentations'] = ManualPresentation::all();
        $data['presentations'] = Presentation::all();
        $data['videos'] = Video::all();
        return redirect()->back();
    }

    public function destroy_download($id)
    {
        /************************
         * Dev testing
         * ->to be removed
         */
        //Remove temp storage in dev
        $presentation = Presentation::find($id);
        Storage::disk('public')->deleteDirectory($presentation->local); //If it not already has been deleted
        Presentation::destroy($id);
        $data['manual_presentations'] = ManualPresentation::all();
        $data['presentations'] = Presentation::all();
        $data['videos'] = Video::all();
        return redirect()->back();
    }

    public function dev_destroy($id)
    {
        /************************
         * Dev testing
         * ->to be removed
         */
        Storage::disk('public')->deleteDirectory($id);
        return redirect()->route('home');
    }
}
