<?php

namespace App\Http\Controllers;

use App\AdminHandler;
use App\ManualPresentation;
use App\MediasiteFolder;
use App\MediasitePresentation;
use App\Permission;
use App\Presentation;
use App\Services\Daisy\DaisyAPI;
use App\Services\DownloadPackageZip;
use App\Services\Notify\PlayStoreNotify;
use App\Services\ReLoadPlayStore;
use App\Video;
use App\VideoPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('entitlements');
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
        return view('admin.admin');
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
                $adminhandler = AdminHandler::updateOrCreate(['Shib_Session_ID' => '9999'], ['override' => false, 'custom' => false, 'user' => '', 'username' => '']);
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

                //dd($person['email']);


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
                AdminHandler::updateOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')], ['override' => false]);
            } else {
                $adminhandler = AdminHandler::firstOrCreate(['Shib_Session_ID' => $request->server('Shib_Session_ID')]);
                $adminhandler->override = true;
                $adminhandler->role = $request->role;
                $adminhandler->save();
            }
        }

        return back()->withInput();
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

        //Remove temp storage
        Storage::disk('public')->deleteDirectory($presentation->local);

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
