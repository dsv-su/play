<?php

namespace App\Services\Notify;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlayStoreNotify extends Model
{
    protected $json, $client, $headers, $response;
    private $file, $system_config;

    public function __construct(Model $model)
    {
        $this->presentation = $model;
    }

    public function sendSuccess(string $type)
    {
        // type: manual | type: update
        $this->presentation
            ->makeHidden('status')
            ->makeHidden('local')
            ->makeHidden('permission')
            ->makeHidden('entitlement')
            ->makeHidden('created_at')
            ->makeHidden('updated_at');

        //Make json wrapper
        $this->json = Collection::make([
            'status' => 'success',
            'type' => $type
        ]);
        $this->json['package'] = $this->presentation;
        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //*********************************************************************************
        //return $this->json;
        //*********************************************************************************

        $this->client = new Client(['base_uri' => $this->uri()]);
        $this->headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
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
                $this->presentation->status = 'failed';
                $this->presentation->save();
                //TODO Store error
                return $this->response = $e->getResponse()->getBody();
            }
        }

        if($this->response->getBody() == 'OK') {
            //Change manualupdate status
            $this->presentation->status = 'sent';
            $this->presentation->save();
            return redirect('/')->with(['message' => 'Presentationen har redigerats och laddats upp!']);
        }
        else {
            //Change manualupdate status
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
            ->makeHidden('base')
            ->makeHidden('local')
            ->makeHidden('title')
            ->makeHidden('presenters')
            ->makeHidden('created')
            ->makeHidden('duration')
            ->makeHidden('courses')
            ->makeHidden('tags')
            ->makeHidden('thumb')
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
            'base' => $this->presentation->base
        ]);

        $this->json = $this->json->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        //*********************************************************************************
        //return $this->json;
        //*********************************************************************************

        $this->client = new Client(['base_uri' => $this->uri()]);
        $this->headers = [
            //'Authorization' => 'Bearer ' . $this->token(),
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
                $this->presentation->status = 'failed';
                $this->presentation->save();
                //TODO Store error
                return $this->response = $e->getResponse()->getBody();
            }
        }

        if($this->response->getBody() == 'OK') {
            //Change manualupdate status
            $this->presentation->status = 'notified';
            $this->presentation->save();
            return back()->withInput();
        }
        else {
            //Change manualupdate status
            $this->presentation->status = 'failed';
            $this->presentation->save();
            //TODO Store error
            return $this->response->getBody();
        }
    }

    private function uri()
    {
        $this->file = base_path().'/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path().'/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['sftp']['uri'];
    }
}
