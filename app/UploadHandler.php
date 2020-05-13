<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class UploadHandler
{
    public function getUpload($file)
    {

        //Get array of streams
        $contents = Storage::get($file);

        foreach (explode(PHP_EOL, $contents,-1) as $key=>$line)
        {
            $list[] = $line;
        }

        return $list;
    }
}
