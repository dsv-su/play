<?php

namespace App\Services\PacketHandler;

use App\Stream;

class UpdatePackage
{
    public function local()
    {
        //Updates local main stream name
        $streams = Stream::where('audio', true)->limit(2)->get();
        foreach ($streams as $stream) {
            $stream->name = 'main';
            $stream->save();
        }
    }

}
