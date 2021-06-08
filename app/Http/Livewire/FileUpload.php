<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class FileUpload extends Component
{
    use WithFileUploads;
    public $files = [];
    public $filenames = [];
    public $filethumbs = [];
    public $filethumbsname = [];
    public $sec;
    public $dirname;
    public $presentation, $permissions;
    public $title, $created;
    public $presenters = [];

    public function mount($presentation, $permissions)
    {
        $this->dirname = $presentation->local;
        $this->permissions = $permissions;
    }

    public function updatedfiles()
    {

        $this->validate([
            'files.*' => 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
            'files' => 'max:4',
        ],
        [
            'files.mimetypes' => 'The files must be of type',
            'files.max' => 'The maximum number of files allowed is 4',
        ]);

        if(count($this->filenames)>3) {
            $this->emit('show');
        } else {
            //Store file
            foreach($this->files as $item) {

                $filename = $item->store($this->dirname . '/video', 'public');
                $this->filenames[] = $filename;
                $this->filethumbs[] = $this->createThumb($filename, 10);
            }

            session()->flash('message', 'File successfully Uploaded.');
        }

    }

    public function createThumb($media, $seconds)
    {
        $base = basename($media);
        $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $base);
        //$thumb = substr($withoutExt, strpos($withoutExt, '/', 1));
        //Generate thumb
        //Create thumb and store in folder
        FFMpeg::fromDisk('public')
            ->open($media)
            ->getFrameFromSeconds($seconds)
            ->export()
            ->toDisk('public')
            ->save($this->dirname.'/poster/'.$thumb_name.'.png');
        //Store thumb path
        $this->filethumbsname[] = $this->dirname.'/poster/'.$thumb_name.'.png';

        return Storage::disk('public')->url($this->dirname.'/poster/'.$thumb_name.'.png');
    }

    public function regenerate($gthumb)
    {
        $this->validate([
            'sec' => 'required',
        ]);
        $this->filethumbs[$gthumb] = $this->createThumb($this->filenames[$gthumb], $this->sec);

    }

    public function submit()
    {

        $this->validate([
            'title' => 'required',
            'created' => 'required',
        ]);
        dd('Submitted', $this->title, $this->created, $this->presenters);
        //Validate file


    }

    public function remove($index)
    {
        //dd($this->filethumbsname[$index]);
        Storage::disk('public')->delete($this->filethumbsname[$index]);
        Storage::disk('public')->delete($this->filenames[$index]);
        array_splice($this->filenames, $index, 1);
        array_splice($this->filethumbs, $index, 1);
    }

    public function render()
    {
        return view('livewire.file-upload');
    }

}
