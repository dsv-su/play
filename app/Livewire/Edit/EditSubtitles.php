<?php

namespace App\Livewire\Edit;

use App\Models\ManualPresentation;
use App\Services\AuthHandler;
use App\Services\Store\DownloadResource;
use App\Services\TicketHandler\Entitlement;
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

        // Get token (throws/aborts if not allowed)
        $token = $this->getToken($this->video);

        // Use the token to download the file
        $downloader = new DownloadResource($token);

        /*$file = new DownloadResource($this->getToken($this->video));

        $path = 'subtitles/download/'.$this->video->id.'/'. $this->subtitles[$value];
        $file->getFile($path, $this->baseUri() . '/' . $this->video->id . '/' . $this->subtitles[$value]);*/

        $filename = $this->subtitles[$value];
        $path     = 'subtitles/download/' . $this->video->id . '/' . $filename;

        $downloader->getFile(
            $path,
            $this->baseUri() . '/' . $this->video->id . '/' . ltrim($filename, '/')
        );
        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
    }

    /**
     * Get a download token for this video, using current request entitlements.
     */
    public function getToken(Video $video): string
    {
        // Resolve the dependencies here so callers can stay simple
        /** @var Entitlement $entitlement */
        $entitlement = app(Entitlement::class);

        /** @var TicketPermissionHandler $handler */
        $handler = new TicketPermissionHandler($entitlement);
        // or: $handler = app(TicketPermissionHandler::class);

        $token = $handler->issue($video, $this->getEntitlements());

        // If not allowed, guard early
        if ($token === '' || $token === null) {
            abort(403, 'Download not permitted.');
        }

        return (string) $token;
    }

    /**
     * Extract the provided entitlements from headers/request context.
     */
    public function getEntitlements(): array
    {
        $param      = data_get(app(AuthHandler::class)->authorize(), 'global.authorization_parameter');
        $headerName = $this->normalizeHeaderName($param);

        $raw = (string) ($_SERVER[$headerName] ?? request()->server($headerName) ?? '');

        return $this->splitEntitlements($raw);
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

    private function splitEntitlements(string $value): array
    {
        return array_values(array_filter(
            array_map('trim', explode(';', $value)),
            static fn ($v) => $v !== ''
        ));
    }

    private function normalizeHeaderName(string $param): string
    {
        // If it's given as 'HTTP_X_USER_ENTITLEMENTS', convert to 'X-User-Entitlements'
        if (str_starts_with($param, 'HTTP_')) {
            $param = substr($param, 5);
            $param = str_replace('_', '-', $param);
        }
        // HeaderBag is case-insensitive, so case doesn’t matter, but this is fine.
        return $param;
    }

    public function render()
    {
        return view('livewire.edit.edit-subtitles');
    }
}
