<?php

namespace App\Livewire\Edit;

use App\Models\Video;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use stdClass;


class EditTags extends Component
{
    public ?Video $video = null;
    public $tags = [];
    public string $searchTag = '';
    public array $videoTags = [];
    public int $highlighted = 0;

    public function mount($video): void
    {
        if ($video) {
            // Edit mode: ensure video is available
            $this->video = $video->loadMissing(['tags']);
        }

        $this->associatedTags();

        if ($this->searchTag !== '') {
            $this->tags = $this->searchTags();
        }
    }

    public function updatedSearchTag(): void
    {
        $this->tags = $this->searchTags();
    }

    public function moveHighlight(int $direction): void
    {
        $count = count($this->tags);
        if ($count === 0) return;

        $this->highlighted = ($this->highlighted + $direction + $count) % $count;
    }

    public function addHighlighted(): void
    {
        if (isset($this->tags[$this->highlighted])) {
            $tag = $this->tags[$this->highlighted];
            $this->addTag($tag['id'], $tag['name']);
        }
    }

    public function searchTags(): array
    {
        $q = trim((string) $this->searchTag);

        if ($q === '') {
            return $this->tags = [];
        }

        $terms = collect(preg_split('/\s+/', $q))
            ->filter()
            ->map(fn ($t) => trim($t))
            ->unique()
            ->values();

        if ($terms->isEmpty()) {
            return $this->tags = [];
        }

        // 1) Scout -> Eloquent models -> map to plain arrays
        $results = Tag::search($q)->take(10)->get()
            ->map(fn (Tag $t) => [
                'id'   => $t->id,
                'name' => $t->name,

            ])
            ->values()
            ->all();

        // 2) Exact-match check (case-insensitive) against the full input string
        $hasExact = collect($results)->contains(
            fn (array $item) => Str::lower($item['name']) === Str::lower($q)
        );

        // 3) If no exact match, prepend an array "input" option
        if (! $hasExact) {
            array_unshift($results, [
                'id'   => null,
                'name' => $q,
                'type' => 'input',
            ]);
        }

        // 4) Assign a uniform array to the Livewire property
        $this->tags = $results;

        return $this->tags;
    }

    public function addTag($tagID, $tagName)
    {

        if($tagID) {
            //Associate
            $this->videoTags[] = [
                'id' => $tagID,
                'name' => $tagName
            ];
        } else {
            //Create and Associate
            $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
            $this->videoTags[] = [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        }
        $this->tags = [];
        $this->searchTag = '';
    }

    public function remove_tag($index)
    {
        array_splice($this->videoTags, $index, 1);
    }

    public function associatedTags()
    {
        if($this->video?->exists) {
            foreach ($this->video->tags as $t) {
                $this->videoTags[] = [
                    'id' => $t->id,
                    'name' => $t->name
                ];
            }
        }

    }

    public function render()
    {
        return view('livewire.edit.edit-tags');
    }
}
