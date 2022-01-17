<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DownloadPackageZip extends Model
{
    protected $destination, $package_dir;
    protected $zipFileName, $zip;

    public function makezip()
    {
        Storage::disk('public')->makeDirectory('backup_zip');
        //Create zip file of created packages
        $this->destination = storage_path('app/public/backup_zip/');
        $this->zipFileName = $this->destination.'package.zip';
        //Directory of unzipped files
        $this->package_dir = public_path().'/storage/backup';

        //Creates a zip file of the entire raw folder
        $zip = new \ZipArchive();
        $zip->open($this->zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->package_dir));
        foreach ($files as $key => $file)
        {
            // Skipping subfolders
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = 'Package/' . substr($filePath, strlen($this->destination)-2);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        return true;

    }
}
