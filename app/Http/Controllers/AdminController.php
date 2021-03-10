<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Permission;
use App\Presentation;
use App\Services\Notify\PlayStoreNotify;
use App\Video;
use App\VideoPermission;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('play-store-status:api');
    }

    public function admin()
    {
        $data['manual_presentations'] = ManualPresentation::all();
        $data['presentations'] = Presentation::all();
        $data['videos'] = Video::all();
        $data['owners'] = Video::with('video_presenter.presenter')->get();
        $data['permissions'] = VideoPermission::with('permission')->get();

        return view('admin.admin', $data);
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

    public function adminSetPermission(Video $video)
    {
        $permissions = Permission::all();
        $thispermissions = VideoPermission::where('video_id', $video->id)->pluck('permission_id','type')->toArray();

        return view('admin.permission.permission', $video, compact('permissions','thispermissions'));
    }

    public function adminStorePermission($id, Request $request): RedirectResponse
    {
        $video_permissions = VideoPermission::where('video_id', $id)->get();
        //Delete old settings
        foreach($video_permissions as $vp) {
            $vp->delete();
        }
        //Add new settings
        foreach($request->perm as $permission) {
            $vp = new VideoPermission();
            $vp->video_id = $id;
            $vp->permission_id = $permission;
            if($permission == 1) {
                $vp->type = 'public';
            } else {
                $vp->type = 'private';
            }
            $vp->save();
        }

        return redirect()->route('admin');
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
        return view('manual.admin', $data);
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
        return view('manual.admin', $data);
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
