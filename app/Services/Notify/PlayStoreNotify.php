<?php

namespace App\Services\Notify;

use App\ManualPresentation;
use App\MediasitePresentation;
use App\VideoPermission;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class PlayStoreNotify extends Model
{

    protected $json, $client, $headers, $response, $title;
    protected $log;
    private $file, $system_config;

    public function __construct(Model $model)
    {
        $this->presentation = $model;
    }

    public function sendSuccess(string $type)
    {
        // type: default | type: edit | type: mediasite

        $this->presentation
            ->makeHidden('id')
            ->makeHidden('title_en')
            ->makeHidden('status')
            ->makeHidden('type')
            ->makeHidden('jobid')
            ->makeHidden('duration')
            ->makeHidden('autogenerate_subtitles')
            ->makeHidden('user')
            ->makeHidden('user_email')
            ->makeHidden('local')
            ->makeHidden('visibility')
            ->makeHidden('unlisted')
            ->makeHidden('files')
            ->makeHidden('permission')
            ->makeHidden('entitlement')
            ->makeHidden('daisy_courses')
            ->makeHidden('created_at')
            ->makeHidden('updated_at');

        //Conditions
        //Pkg_id
        if(empty($this->presentation->pkg_id)) {
            $this->presentation->makeHidden('pkg_id');
        }
        //upload_dir
        if(empty($this->presentation->upload_dir)) {
            $this->presentation->makeHidden('upload_dir');
        }
        //Presenters
        if(empty($this->presentation->presenters)) {
            //$this->presentation->makeHidden('presenters');
            $this->presentation->presenters = [];
        }
        //Courses
        if(empty($this->presentation->courses)) {
            //$this->presentation->makeHidden('courses');
            $this->presentation->courses = [];
        }
        //Tags
        if(empty($this->presentation->tags)) {
            //$this->presentation->makeHidden('tags');
            $this->presentation->tags = [];
        }
        //Subs
        if(empty($this->presentation->subtitles)) {
            $this->presentation->makeHidden('subtitles');
        }
        //Autogenerate subs
        if(!$this->presentation->autogenerate_subtitles) {
            $this->presentation->makeHidden('generate_subtitles');
        }

        //Check if subtitles has been uploaded
        if(!$this->presentation->subtitles) {
            $this->presentation
                ->makeHidden('subtitles');
        }
        //Check if description has been uploaded
        if(!$this->presentation->description) {
            $this->presentation
                ->makeHidden('description');
        }

        //Exceptions
        if ($type == 'default' or $type == 'edit') {
            $this->presentation->title = ['sv' => $this->presentation['title'], 'en' => $this->presentation['title_en']];
        } elseif ($type == 'mediasite') {
            $this->presentation->title = ['sv' => $this->presentation['title'], 'en' => $this->presentation['title']];
        }

        if ($type == 'edit') {
            $this->presentation
                ->makeHidden('thumb');
            $this->presentation->thumbnail = '';

            //For now
            $this->presentation
                ->makeHidden('sources');
        }

        if ($type == 'mediasite') {
            $this->presentation->makeHidden('video_id')->makeHidden('mediasite_folder_id');
        }

        $this->json = $this->presentation;
        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Success
        //return $this->json;
        //

        $this->client = new Client(['base_uri' => $this->uri()]);

        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $uri = ($type == 'mediasite') ? $this->mediasite_uri() : $this->uri();
            $this->response = $this->client->request('POST', $uri, [
                'headers' => $this->headers,
                'body' => $this->json
            ]);
        } catch (\Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {

                //Change model status
                $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
                $this->presentation->status = 'failed';
                $this->presentation->save();

                //Write info to log
                Log::error($e->getResponse()->getBody());

                return $this->response = $e->getResponse()->getBody();
            }
        }

        if ($type == 'mediasite') {
            //Drop slides property since it's no longer needed to save
            unset($this->presentation->slides);
        }

        if (!empty( $this->presentation->jobid = (string) $this->response->getBody() ) ) {

            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            $this->presentation->jobid = (string) $this->response->getBody();
            $this->presentation->status = 'sent';
            $this->presentation->save();

            if (App::isLocale('swe')) {
                $message = 'Bearbetar presentationen';
            } else {
                $message = 'Processing the presentation';
            }

            //Update VideoPermissions
            if($type == 'edit') {
                $videopermissions = VideoPermission::where('video_id', $this->presentation->pkg_id)->first();
            } else {
                $videopermissions = VideoPermission::where('notification_id', $this->presentation->id)->first();
            }
            $videopermissions->jobid = (string) $this->response->getBody();
            $videopermissions->save();

            if($type == 'edit') {
                return true;
            }

            return redirect('/')->with(['message' => $message]);
        } else {
            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            if (App::isLocale('swe')) {
                $message = 'Något gick fel med uppladdningen';
            } else {
                $message = 'Something went wrong with the upload';
            }
            $this->presentation->status = 'failed';
            $this->presentation->save();

            return redirect('/')->with(['message' => $message]);
        }
    }

    public function sendFail(string $type)
    {
        // type: manual
        $this->presentation
            ->makeHidden('id')
            ->makeHidden('status')
            ->makeHidden('user')
            ->makeHidden('upload_dir')
            ->makeHidden('local')
            ->makeHidden('title')
            ->makeHidden('presenters')
            ->makeHidden('created')
            ->makeHidden('duration')
            ->makeHidden('courses')
            ->makeHidden('tags')
            ->makeHidden('thumb')
            ->makeHidden('files')
            ->makeHidden('sources')
            ->makeHidden('permission')
            ->makeHidden('entitlement')
            ->makeHidden('created_at')
            ->makeHidden('updated_at');

        //Make json wrapper
        $this->json = Collection::make([
            'status' => 'failure',
            'type' => $type
        ]);
        $this->json['package'] = Collection::make([
            'message' => $this->presentation->status,
            'upload_dir' => $this->presentation->upload_dir
        ]);

        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Fail
        //return $this->json;
        //

        $this->client = new Client(['base_uri' => $this->uri()]);
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        try {
            $this->response = $this->client->request('POST', $this->uri(), [
                'headers' => $this->headers,
                'body' => $this->json
            ]);
        } catch (\Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                //Change model status
                $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
                $this->presentation->status = 'failed';
                $this->presentation->save();

                //Write info to log
                Log::error($e->getResponse()->getBody());

                return $this->response = $e->getResponse()->getBody();
            }
        }

        if ($this->response->getBody()) {
            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            $this->presentation->status = 'notified fail';
            $this->presentation->save();

            return back()->withInput();

        } else {
            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            $this->presentation->status = 'notification error';
            $this->presentation->save();
            //TODO Store error
            return $this->response->getBody();
        }
    }

    public function sendDelete()
    {
        $this->client = new Client(['base_uri' => $this->base_uri()]);
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

       $this->auth = Collection::make([
            'auth' => $this->storeauth()
        ]);
        $this->auth = $this->auth->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        try {
            $this->response = $this->client->request('DELETE', $this->base_uri() . '/' . $this->presentation->id, [
                'headers' => $this->headers,
                'body' => $this->auth
            ]);
        } catch (\Exception $e) {
            /**
             * If there is an exception; Client error;
             */
            if ($e->hasResponse()) {
                return $this->response = $e->getResponse()->getBody();
            }
        }

        if ($this->response->getBody()) {
            return true;
        } else {
            //TODO Error handling
            return json_decode($this->response->getBody(), true);
        }
    }

    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['notify_uri'];
    }

    private function mediasite_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['notify_mediasite_uri'];
    }

    private function storeauth()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['notify_auth'];
    }
}
