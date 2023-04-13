<?php

namespace App\Services\Notify;

use App\ManualPresentation;
use App\MediasitePresentation;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class PlayStoreNotify extends Model
{

    protected $json, $client, $headers, $response, $title;
    private $file, $system_config;

    public function __construct(Model $model)
    {
        $this->presentation = $model;
    }

    public function sendSuccess(string $type)
    {
        // type: default | type: mediasite

        $this->presentation
            ->makeHidden('title_en')
            ->makeHidden('status')
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

        //Check if subtitles has been uploaded
        if(!$this->presentation->subtitles) {
            $this->presentation
                ->makeHidden('subtitles');
        }

        //Exceptions
        if ($type == 'default') {
            $this->presentation->title = ['sv' => $this->presentation['title'], 'en' => $this->presentation['title_en']];
        } elseif ($type == 'mediasite') {
            $this->presentation->title = ['sv' => $this->presentation['title'], 'en' => $this->presentation['title']];
        }

        if ($type == 'update') {
            $this->presentation
                ->makeHidden('resolution');
        }

        if ($type == 'mediasite') {
            $this->presentation->makeHidden('video_id')->makeHidden('mediasite_folder_id');
        }

        //Make json wrapper
        $this->json = Collection::make([
            'status' => 'success',
            'type' => $type
        ]);

        $this->json['package'] = $this->presentation;

        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //
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

        if ($this->response->getBody()) {
            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            $this->presentation->status = 'sent';
            $this->presentation->save();

            if (App::isLocale('swe')) {
                $message = 'Bearbetar presentationen';
            } else {
                $message = 'Processing the presentation';
            }

            return redirect('/')->with(['message' => $message]);
        } else {
            //Change manualupdate status
            $this->presentation = ($type == 'mediasite') ? MediasitePresentation::find($this->presentation->id) : ManualPresentation::find($this->presentation->id);
            $this->presentation->status = 'failed';
            $this->presentation->save();
            //TODO Store error
            return $this->response->getBody();
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

        //
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
