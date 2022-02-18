<?php

namespace App\Services\Store;

use App\Services\TicketHandler\TicketPermissionHandler;
use App\Video;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class DownloadResource extends Model
{
    protected $video, $ticket, $token;

    public function __construct(Video $video, TicketPermissionHandler $ticketHandler)
    {
        $this->video = $video;
        $this->ticket = $ticketHandler;
        //Issue ticket for download resource
        $this->token = $this->ticket->issue();
    }

    public function getFile($storage, $url)
    {
        $client = new Client();

        $resource = storage_path('app/public/'.$storage);

       $response = $client->request('GET', $url, [
           'cache' => 'no-cache',
           'query' =>['token' => $this->token],
            'sink' => $resource,
        ]);

    }
}
