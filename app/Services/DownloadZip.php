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

    /**
     * @throws RuntimeException If the file cannot be opened
     */

    public function makezip()
    {
        //Create zip file of downloaded files and folders
        $this->destination = storage_path('app/public/'.$this->path.'/');

        //Directory of unzipped files
        $this->public_dir = storage_path('app/public/'.$this->path);

        $filePath = $this->destination.$this->video->title.'.zip';
        $zip = new \ZipArchive();

        if ($zip->open($filePath, \ZipArchive::CREATE) !== true) {
            throw new \RuntimeException('Cannot open ' . $filePath);
        }

        $this->addContent($zip, $this->public_dir);
        $zip->close();

        return true;
    }

    /**
     * This takes symlinks into account.
     *
     * @param ZipArchive $zip
     * @param string     $path
     */

    private function addContent(\ZipArchive $zip, string $path)
    {
        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::FOLLOW_SYMLINKS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path) + 1);

                if (!$iterator->isDir()) {
                    $zip->addFile($filePath, $relativePath);
                } else {
                    if ($relativePath !== false) {
                        $zip->addEmptyDir($relativePath);
                    }
                }
            }
            $iterator->next();
        }
    }

}
