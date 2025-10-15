<?php

namespace App\Livewire\Edit;

use App\Models\Video;
use Illuminate\Support\Collection;
use Livewire\Component;

class EditStreams extends Component
{
    public Video $video;
    public array $audio = [];
    public array $streamVisibility = [];

    /** @var array<int, array{audio:bool, hidden:bool, poster:?string}> */
    public array $streams = [];

    public function mount(Video $video): void
    {
        $this->video = $video->loadMissing([
            'streams:id,video_id,name,audio,hidden,poster',
        ]);
        $this->getStreams();
        $this->getAudio();
    }

    public function updatedAudio($value, $index)
    {
        // First, set the selected index to the passed value
        $this->streams[$index]['audio'] = $value;
        $this->audio[$index] = $value;

        // Then loop through all other streams and set their audio to false
        foreach ($this->streams as $i => $stream) {
            if ($i !== (int)$index) {
                $this->streams[$i]['audio'] = false;
                $this->audio[$i] = false;
            }
        }
    }

    public function updatedStreamVisibility($value, $index)
    {
        $this->streamVisibility[$index] = $value;
        $this->streams[$index]['hidden'] = $value;
    }

    public function getAudio()
    {
        foreach ($this->streams as $i => $stream) {
            $this->audio[] = $stream['audio'];
        }
    }

    public function getStreams()
    {
        $base = $this->baseUri();
        // Normalize streams into a simple array that the view can iterate
        $this->streams = $this->video->streams
            ->map(function ($stream) use ($base) {
                return [
                    'title' => $stream->name,
                    'audio'  => (bool) $stream->audio,
                    'hidden' => (bool) $stream->hidden,
                    'poster' => $stream->poster
                        ? rtrim($base, '/') . '/' . $this->video->id . '/' . ltrim($stream->poster, '/')
                        : null,
                ];
            })
            ->values()
            ->all();
        foreach ($this->streams as $i => $stream) {
            $this->streamVisibility[] = $stream['hidden'];
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

        // return view('livewire.edit.edit-streams', ['streams' => $this->streams]);
        return view('livewire.edit.edit-streams');
    }
}

