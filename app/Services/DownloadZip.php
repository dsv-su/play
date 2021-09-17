<?php

namespace App\Services;

use App\Video;
use Illuminate\Database\Eloquent\Model;

class DownloadZip extends Model
{
    protected $video, $path, $destination, $public_dir;
    protected $zipFileName, $zip;

    public function __construct(Video $video, $path)
    {
        $this->video = $video;
        $this->path = $path;
    }

    public function makezip()
    {
        //Create zip file of downloaded files and folders
        $this->destination = storage_path('app/public/'.$this->path.'/');
        $this->zipFileName = $this->destination.$this->video->id.'.zip';
        //Directory of unzipped files
        $this->public_dir = public_path().'/storage/'.$this->path;

        //Creates a zip file of the entire raw folder
        $zip = new \ZipArchive();
        $zip->open($this->zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->destination));
        foreach ($files as $key => $file)
        {
            // Skipping subfolders
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = $this->video->title.'/' . substr($filePath, strlen($this->destination) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        return true;

    }
}
