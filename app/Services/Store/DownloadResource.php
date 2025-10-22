<?php

namespace App\Services\Store;

use App\Services\TicketHandler\TicketPermissionHandler;
use App\Models\Video;
use GuzzleHttp\Client;

class DownloadResource
{
    protected $video, $ticket, $token;

    public function __construct(Video $video, TicketPermissionHandler $ticketHandler)
    {
        $this->video = $video;
        $this->ticket = $ticketHandler;
        //Issue ticket for download resource
        $entitlements = [];
        $this->token   = $this->ticket->issue($this->video, $entitlements);
    }


    public function getFile($storage, $url)
    {
        $client = new Client();
        $resource = storage_path('app/public/'.$storage);

        \Log::notice('preparing get request', ['token' => $this->token]);

       $response = $client->request('GET', $url, [
           'cache' => 'no-cache',
           'query' =>['token' => $this->token],
            'sink' => $resource,
        ]);

    }
}
