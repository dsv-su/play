<?php

namespace App\Http\Controllers;

use App\AdminHandler;
use App\CourseadminPermission;
use App\IndividualPermission;
use App\Jobs\JobUploadFailedNotification;
use App\ManualPresentation;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Permission;
use App\Presentation;
use App\Presenter;
use App\Services\Daisy\DaisyAPI;
use App\Services\DownloadPackageZip;
use App\Services\Ldap\SukatUser;
use App\Services\Notify\PlayStoreNotify;
use App\Services\ReLoadPlayStore;
use App\Stream;
use App\StreamResolution;
use App\Video;
use App\VideoCourse;
use App\VideoPermission;
use App\VideoPresenter;
use App\VideoStat;
use App\VideoTag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Storage;
use stdClass;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('entitlements');
        $this->middleware('play-admin')->except(['emulateUser', 'findUser']);
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
        return view('admin.admin');
    }

    public function uploads()
    {
        $data['manual_presentations'] = ManualPresentation::all();
        $data['queued_presentations'] = Video::where('state', 0)->orderBy('updated_at', 'desc')->get();
        return view('admin.partials.uploads', $data);
    }

    public function downloads()
    {
        $data['presentations'] = Presentation::all();
        return view('admin.partials.downloads', $data);
    }

    public function mediasite()
    {
        $data['mediasite_presentations'] = MediasitePresentation::all()->where('status', '<>', null);
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
        if (!$request->server('REMOTE_USER')) {
            //No Shib_Session_ID
            if ($request->role == 'Administrator') {
                $adminhandler = AdminHandler::updateOrCreate(['Shib_Session_ID' => '9999'], ['override' => false, 'role' => 'Administrator', 'custom' => false, 'user' => '', 'username' => '']);
            }
            elseif ($request->role == 'custom') {
                //Strip domain suffix
                if (strpos($request->custom, '@') !== false) {
                    $userID = substr($request->custom, 0, strpos($request->custom, "@"));
                } else {
                    $userID = $request->custom;
                }

                //Store user info
                $daisy = new DaisyAPI();
                $person = $daisy->getDaisyEmployee($userID);

                //Update AdminHandler
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => '9999']);
                $adminhandler->override = true;
                $adminhandler->custom = true;
                $adminhandler->username = $userID;
                $adminhandler->user = $person['firstName'] . ' ' . $person['lastName'];
                //Check if user is employee or student
                if($daisy->checkifEmployee($person['id'])) {
                    $adminhandler->role = 'Courseadmin';
                } else {
                    $adminhandler->role = 'Student';
                }

                $adminhandler->save();
            }
            else {
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => '9999']);
                $adminhandler->override = true;
                $adminhandler->custom = false;
                $adminhandler->user = '';
                $adminhandler->username = '';
                $adminhandler->role = $request->role;
                $adminhandler->save();
                if (in_array($adminhandler->role, ['Student', 'Student1', 'Student2', 'Student3'])) {
                    return redirect()->route('home');
                }

            }

        } else {
            //Has Shib_Session_ID
            if ($request->role == 'Administrator') {
                AdminHandler::updateOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')], ['override' => false, 'role' => 'Administrator', 'custom' => false, 'user' => '', 'username' => '']);
            }
            elseif ($request->role == 'custom') {
                //Strip domain suffix
                if (strpos($request->custom, '@') !== false) {
                    $userID = substr($request->custom, 0, strpos($request->custom, "@"));
                } else {
                    $userID = $request->custom;
                }

                //Store user info
                $daisy = new DaisyAPI();
                $person = $daisy->getDaisyEmployee($userID);

                //Update AdminHandler
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')]);
                $adminhandler->override = true;
                $adminhandler->custom = true;
                $adminhandler->username = $userID;
                $adminhandler->user = $person['firstName'] . ' ' . $person['lastName'];
                //Check if user is employee or student
                if($daisy->checkifEmployee($person['id'])) {
                    $adminhandler->role = 'Courseadmin';
                } else {
                    $adminhandler->role = 'Student';
                }

                $adminhandler->save();
            }
            else {
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')]);
                $adminhandler->override = true;
                $adminhandler->custom = false;
                $adminhandler->user = '';
                $adminhandler->username = '';
                $adminhandler->role = $request->role;
                $adminhandler->save();
            }
        }

        return back()->withInput();
    }

    /** Method for user search autocomplete suggestions
     * @param Request $request
     * @return Collection
     */
    public function findUser(Request $request): Collection
    {
        $searchterms = preg_split('/\s+/', $request->custom);
        $search = '(&';
        foreach ($searchterms as $term) {
            $search .= "(|(givenName=$term*)(sn=$term*))";
        }
        $search .= ')';


        $sukatusersdsv = SukatUser::rawFilter($search)->whereContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:staff')->get();

        //Students
        /*$sukatusersstudents = SukatUser::rawFilter($search)
            ->whereContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:student')
            ->whereNotContains('edupersonentitlement', 'urn:mace:swami.se:gmai:dsv-user:staff')
            ->get();
        */
        foreach ($sukatusersdsv as $su) {
            $su->role = 'DSV';

        }

        /*foreach ($sukatusersstudents as $su) {
            $su->role = 'Student';
        }
        */

        $users = new Collection();
        //foreach ($sukatusersdsv->merge($sukatusersstudents) as $su) {
        foreach ($sukatusersdsv as $su) {
            $user = new stdClass();
            if (!$su->uid) {
                continue;
            }
            $user->uid = $su->uid[0];
            $user->name = $su->displayName[0];
            $user->role = $su->role;
            $users->add($user);
        }

        return $users->take(20);
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
                'permission_en' => 'required',
                'entitlement' => 'required'
            ]);
            if ($request->modify == 0) {
                Permission::updateOrCreate(
                    ['scope' => $request->permission],
                    ['scope_en' => $request->permission_en, 'entitlement' => $request->entitlement]
                );
            } else {
                $permission = Permission::find($request->pid);
                $permission->scope = $request->permission;
                $permission->scope_en = $request->permission_en;
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

    public function package_queue_erase($id)
    {
        $video = Video::find($id);

        //Start transaction
        DB::beginTransaction();

        //Only remove non-existent presentations
        if($video->type != 'edit') {
            try {
                VideoCourse::where('video_id', $id)->delete();
                VideoTag::where('video_id', $id)->delete();
                VideoPresenter::where('video_id', $id)->delete();
                VideoPermission::where('video_id', $id)->delete();
                VideoStat::where('video_id', $id)->delete();
                CourseadminPermission::where('video_id', $id)->delete();
                IndividualPermission::where('video_id', $id)->delete();

                $streams = Stream::where('video_id', $id)->get();
                foreach ($streams as $stream) {
                    StreamResolution::where('stream_id', $stream->id)->delete();
                    $stream->delete();
                }
                $video->delete();
            } catch (Exception $e) {
                report($e);
                DB::rollback(); // Something went wrong
                return \Redirect::back()->with('error', true)->with('message', __('Error erasing queue item').': '.$e->getMessage());
            }

            DB::commit();   // Successfully removed
        }

        return back()->withInput();
    }

    public function admin_erase($id)
    {
        $manual = ManualPresentation::find($id);
        Storage::disk('play-store')->deleteDirectory($this->storage(). '/' . $manual->local);
        ManualPresentation::destroy($id);
        return back()->withInput();
    }

    public function admin_cancel($id)
    {
        //Notifies user
        $manual = ManualPresentation::find($id);
        Storage::disk('play-store')->deleteDirectory($this->storage(). '/' . $manual->local);
        $job = (new JobUploadFailedNotification($manual));

        // Dispatch Job and continue
        dispatch($job);

        return back()->withInput();
    }

    public function admin_upload_notify_fail($id)
    {
        $presentation = ManualPresentation::find($id);

        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendFail('manual');

        //Remove temp storage
        Storage::disk('play-store')->deleteDirectory($this->storage(). '/'  . $presentation->local);

        return back()->withInput();
    }

    public function admin_pkg_resend($id)
    {
        $presentation = ManualPresentation::find($id);
        // Send notify
        $notify = new PlayStoreNotify($presentation);
        $notify->sendSuccess('edit');
        //Updated status
        $presentation->status = 'sent';
        $presentation->save();

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

    public function backup_json()
    {
        $videos = Video::all();
        foreach ($videos as $video) {
            $contents = json_encode(json_decode($video->presentation), JSON_PRETTY_PRINT);
            \Illuminate\Support\Facades\Storage::disk('public')->put('backup/' . $video->id . '.json', stripslashes($contents));
        }

        //Make zipfolder
        $file = new DownloadPackageZip();
        $file->makezip();
        Cache::flush();
        return redirect()->action([AdminController::class, 'admin']);
    }

    public function reload_json()
    {
        foreach (Storage::disk('public')->files('backup') as $this->file) {
            $this->file_name[] = substr($this->file, strrpos($this->file, '/') + 1);
        }

        $load = new ReLoadPlayStore();
        $presentations = $this->file_name;
        foreach ($presentations as $presentation) {
            $video = json_decode(Storage::disk('public')->get('/backup/' . $presentation), true);
            //store
            $load->reloadstore(new Request($video));
        }
        return redirect('/')->with(['message' => 'All presentations have been reloaded successfully!', 'alert' => 'alert-success']);
    }

    public function download_json()
    {
        if (Storage::disk('public')->exists('/backup_zip/package.zip')) {
            return Storage::disk('public')->download('/backup_zip/package.zip');
        } else {
            Cache::flush();
            return redirect()->action([AdminController::class, 'admin']);
        }

    }

    public function backup_db()
    {

    }

    public function restore_db()
    {

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
        Storage::disk('play-store')->deleteDirectory($this->storage() . '/' . $id);
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
        Storage::disk('play-store')->deleteDirectory($this->storage() . '/' . $id);
        return redirect()->route('home');
    }

    private function storage()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['nfs']['storage'];
    }
}
