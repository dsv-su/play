<?php

namespace App\Livewire\Edit;

use App\Models\ManualPresentation;
use App\Services\Store\DownloadResource;
use App\Services\TicketHandler\TicketPermissionHandler;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Models\Video;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditSubtitles extends Component
{
    use WithFileUploads;

    public ?Video $video = null;
    public ?ManualPresentation $presentation = null;
    public $files = [];
    public $savedfiles = [];
    public $stored = false;
    public $directory;
    public $subtitles;
    public array $purge = [];
    public array $remove_existing_sub = [];
    public string $sub_language = '';
    public array $uploadedSubLanguage = [];
    public bool $auto;
    public bool $force;

    protected $listeners = [
        'upload_refresh' => '$refresh'
    ];

    public function mount($video = null, $presentation = null): void
    {
        if($video) {
            $this->video = $video;
            $this->directory = 'subtitles/' . $this->video->id;  // relative path inside the disk
        } else {
            //Upload
            $this->presentation = $presentation;
            $this->directory = 'subtitles/' . $this->presentation->local;  // relative path inside the disk
        }


        // Decode and normalize
        $this->subtitles = json_decode($video->subtitles ?? '[]', true) ?: [];
        if (!is_array($this->subtitles)) {
            $subtitles = [];
        }

        //$subtitles is an associative map
        $this->purge = array_fill_keys(array_keys($this->subtitles), false);
    }

    public function setLanguagetoSubtitle($language)
    {
        $this->uploadedSubLanguage[] = $language;
    }

    public function finishUpload($name, $tmpPath, $isMultiple)
    {
        $this->toggleStored();
        $this->cleanupOldUploads();
        $files = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

        $files = array_merge($this->getPropertyValue($name), $files);
        $this->syncInput($name, $files);
    }

    public function storefiles()
    {
        foreach($this->files as $file) {
            $this->savedfiles[$file->getClientOriginalName()] = [
                'path' => $file->store(path: $this->directory),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'subtitle'
            ];
        }

        //Toggled buttons
        $this->toggleStored();
        $this->files = [];
    }

    public function removeExistingFile($value)
    {
        unset($this->subtitles[$value]);
        $this->remove_existing_sub[$value] = true;
    }

    public function downloadExistingFile($value)
    {
        //Create local storage directory
        \Storage::disk('public')->makeDirectory('subtitles/download/' . $this->video->id);
        //Create token
        $file = new DownloadResource($this->video, new TicketPermissionHandler($this->video));
        $path = 'subtitles/download/'.$this->video->id.'/'. $this->subtitles[$value];
        $file->getFile($path, $this->baseUri() . '/' . $this->video->id . '/' . $this->subtitles[$value]);

        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
    }

    public function removefile($id)
    {
        // Get the current files array
        $remove = $this->savedfiles[$id]['path'];

        //For debugging
        //$livewireID = $files[$id]['path'];
        //$tmp = $files[$id]['tmp'];

        if (Storage::exists($remove)) {
            Storage::delete($remove);
        }

        // Remove the specific item by key
        if (isset($this->savedfiles[$id])) {
            unset($this->savedfiles[$id]);
        }
    }

    public function toggleStored()
    {
        $this->stored = !$this->stored;
    }

    public function checkToggle()
    {
        if($this->stored) {
            $this->toggleStored();
        }
    }

    protected function baseUri(): string
    {
        $path = base_path('/systemconfig/play.ini');
        if (!file_exists($path)) {
            $path = base_path('/systemconfig/play.ini.example');
        }

        if (!file_exists($path)) {
            throw new \RuntimeException('Configuration file is missing.');
        }

        $config = parse_ini_file($path, true);
        if (!isset($config['store']['list_uri'])) {
            throw new \RuntimeException('Missing required configuration key: store.list_uri');
        }

        return $config['store']['list_uri'];
    }

    public function render()
    {
        return view('livewire.edit.edit-subtitles');
    }
}
