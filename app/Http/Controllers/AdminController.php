<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Presentation;
use App\Services\Notify\PlayStoreNotify;
use App\Video;
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
        return view('manual.admin', $data);
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

    public function admin_permission($id)
    {
        $video = Video::find($id);
        return view('manual.permission', $video);
    }

    public function admin_permission_store($id, Request $request): RedirectResponse
    {
        $video = Video::find($id);
        $video->permission = $request->permission;
        $video->entitlement = $request->entitlement;
        $video->save();
        return redirect()->route('manual_admin');
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
