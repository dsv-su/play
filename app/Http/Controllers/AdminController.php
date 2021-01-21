<?php

namespace App\Http\Controllers;

use App\ManualPresentation;
use App\Presentation;
use App\Video;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Storage;

class AdminController extends Controller
{
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
        $video = ManualPresentation::find($id);
        $video->makeHidden('status')
            ->makeHidden('local')
            ->makeHidden('base')
            ->makeHidden('title')
            ->makeHidden('presenters')
            ->makeHidden('created')
            ->makeHidden('duration')
            ->makeHidden('courses')
            ->makeHidden('tags')
            ->makeHidden('thumbs')
            ->makeHidden('sources')
            ->makeHidden('created_at')->makeHidden('updated_at');
        //Make json wrapper
        $json = Collection::make([
            'status' => 'failure',
            'type' => 'manual'
        ]);
        $json['package'] = Collection::make([
            'message' => $video->status,
            'base' => $video->base
        ]);

        $json = $json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //Print body (for testing)
        //return $json;
        /******************************************************************************/

        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('POST', $this->uri(), [
                'headers' => $headers,
                'body' => $json
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();
                //Change manualupdate status
                $video->status = 'failed';
                $video->save();
                return $response = $e->getResponse()->getBody();
            }
        }

        if ($response->getBody() == 'OK') {
            //Change manualupdate status
            $video->status = 'notified';
            $video->save();
            return back()->withInput();
        } else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }

        return back()->withInput();
    }

    public function admin_download_notify_resend($id)
    {
        $video = ManualPresentation::find($id);
        $video->makeHidden('status')
            ->makeHidden('local')
            ->makeHidden('base')
            ->makeHidden('title')
            ->makeHidden('presenters')
            ->makeHidden('created')
            ->makeHidden('duration')
            ->makeHidden('courses')
            ->makeHidden('tags')
            ->makeHidden('thumbs')
            ->makeHidden('sources')
            ->makeHidden('created_at')->makeHidden('updated_at');
        //Make json wrapper
        $json = Collection::make([
            'status' => 'failure',
            'type' => 'manual'
        ]);
        $json['package'] = Collection::make([
            'message' => $video->status,
            'base' => $video->base
        ]);

        $json = $json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //Print body (for testing)
        //return $json;
        /******************************************************************************/

        $client = new Client(['base_uri' => $this->uri()]);
        $headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('POST', $this->uri(), [
                'headers' => $headers,
                'body' => $json
            ]);
        } catch (Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //return $response = $e->getResponse()->getStatusCode();
                //Change manualupdate status
                $video->status = 'failed';
                $video->save();
                return $response = $e->getResponse()->getBody();
            }
        }

        if ($response->getBody() == 'OK') {
            //Change manualupdate status
            $video->status = 'notified';
            $video->save();
            return back()->withInput();
        } else {
            //Change manualupdate status
            $video->status = 'failed';
            $video->save();
            return $response->getBody();
        }

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
        Storage::disk('public')->deleteDirectory('/download/'.$presentation->presentation_id);
        Presentation::destroy($id);
        $data['manual_presentations'] = ManualPresentation::all();
        $data['presentations'] = Presentation::all();
        $data['videos'] = Video::all();
        return view('manual.admin', $data);
    }

    public function dev_destroy($id)
    {
        Storage::disk('public')->deleteDirectory('/download/'.$id);
        return redirect()->route('home');
    }
}
