<?php

namespace App\Http\Livewire;

use App\ManualPresentation;
use App\Services\Ffmpeg\DetermineDurationVideo;
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
    public $custom;
    public $sec, $genthumb;
    public $dirname;
    public $presentation, $permissions;
    public $title, $created;
    public $source = [];
    public $uploaded_files;

    public function mount(ManualPresentation $presentation, $permissions)
    {
        $this->dirname = $presentation->local;
        $this->permissions = $permissions;
        $this->uploaded_files = 0;
    }

    public function updatedcustom()
    {
        //Store custom thumb i image folder
        $customthumb = $this->custom->store($this->dirname.'/poster','public');

        //Change thumb name to custom thumb name
        $this->filethumbs[0] = $customthumb;

        //Update source
        $this->presentation->thumb = 'poster/'. basename($customthumb);
        $this->source[0]['poster'] = 'poster/' . basename($customthumb);
        $this->presentation->sources = [];
        $this->presentation->sources = $this->source;
        $this->presentation->save();
    }

    public function updatedfiles()
    {
        //Real-time Validation

        $this->validate([
            'files.*' => 'mimetypes:video/mp4, video/avi, video/mpeg, video/quicktime, video/x-ms-wmv',
            'files' => 'max:4',
        ],
        [
            'files.mimetypes' => 'The files must be of type',
            'files.max' => 'The maximum number of files allowed is 4',
        ]);

        //Check if uploaded files are less than 4
        if(count($this->filenames)>3) {
            $this->emit('show');
        } else {
            //Store file
            foreach($this->files as $key => $item) {
                $filename = $item->store($this->dirname . '/video', 'public');
                //Add file to file container
                $this->filenames[] = $filename;

                //Make source
                $this->source[$this->uploaded_files]['video'] = 'video/'. basename($filename);
                $base = basename($filename);
                $thumb_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $base);
                $this->source[$this->uploaded_files]['poster'] = 'poster/'. $thumb_name.'.png';

                //Store primary media duration
                if($key == 0 and count($this->filenames) < 2 ) {
                    //Store duration
                    $this->presentation->duration = $this->DurationVideo($this->dirname, $filename);
                    $primary_video_name = basename($filename);

                    //Create and store generated thumb
                    $this->filethumbs[] = $this->createThumb($filename, ($this->presentation->duration/3));
                    $this->genthumb = ceil($this->presentation->duration/3);
                    $this->presentation->thumb = 'poster/'. basename($this->filethumbs[0]);

                    //Store playAudio for primary
                    $this->source[0]['playAudio'] = true;
                    $this->presentation->save();
                } else {
                    //posters
                    $this->filethumbs[] = $this->createThumb($filename, ($this->presentation->duration/3));
                }

                //Check media diffs (+- 3 sec)
                if(count($this->filenames) > 1){
                    $media = new DetermineDurationVideo($this->dirname);
                    if(!$media->check()) {
                        $this->emit('diffs');
                    }
                }



                //Uploaded files
                $this->uploaded_files++;

                //Store source
                $this->presentation->sources = [];
                $this->presentation->sources = $this->source;
                $this->presentation->save();
            }

            session()->flash('message', 'File successfully Uploaded.');
        }

    }

    public function DurationVideo($directory, $filename)
    {
        $media = new DetermineDurationVideo($directory);
        //Retrive filename
        $primary_video_name = basename($filename);
        return $media->duration($primary_video_name);
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
        $this->genthumb = $this->sec;
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
