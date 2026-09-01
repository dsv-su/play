<?php

namespace App\Livewire\Edit;

use App\Models\Category;
use App\Models\Video;
use Carbon\Carbon;
use Livewire\Component;

class EditPresentation extends Component
{
    /** Core state */
    public Video $video;
    public string $type = '';
    public string $title;
    public string $title_en;
    public ?string $description = null;

    /** UI fields */
    public bool $render_thumb = false;
    public string $date = '';                 // yyyy-mm-dd for inputs

    public array $categories = [];            // collection->toArray()
    public ?int $category = null;             // selected category id

    /** Visibility */
    public string $visibility = 'private';    // 'visible' | 'private' | 'unlisted'
    public bool $download = false;
    public bool $download_switch_warning = false;

    /** Authorization / relations */
    public $allowedCourseIds = [];


    public function mount(Video $video, string $type, $allowedCourseIds): void
    {
        $this->video = $video->loadMissing(['courses', 'category']);
        $this->type = $type;

        //Populate fields
        $this->title = $this->video->title;
        $this->title_en = $this->video->title_en;
        $this->description = $this->video->description;

        // Dates: incoming `$video->creation` assumed unix timestamp
        $this->date = $this->formatTimestampForInput($this->video->creation);

        // Courses & allowed ids provided from parent
        $this->allowedCourseIds  = $allowedCourseIds;

        // Categories for select
        $this->categories = Category::query()
            ->orderBy('category_name')
            ->get(['id', 'category_name'])
            ->toArray();

        // Keep the existing category, or default uncategorized presentations.
        $this->category = $this->video->category_id ?? 1;

        // Visibility: normalize from model fields (visibility + unlisted booleans)
        $this->visibility = $this->video->unlisted
            ? 'unlisted'
            : ($this->video->visibility ? 'visible' : 'private');

        $this->download = (bool)$this->video->download;
    }

    public function updated($name, $value)
    {
        // Turn on thumb rendering when either title field changes
        if (in_array($name, ['title', 'title_en', 'description'])) {
            $this->render_thumb = true;
        }
    }

    /** Keep the three states in sync with any UI toggles */
    public function updatedVisibility(string $state): void
    {
        $state = in_array($state, ['visible', 'private', 'unlisted'], true) ? $state : 'private';
        $this->visibility = $state;

        // Example UX rule retained from your code:
        if ($this->visibility === 'private') {
            $this->download = false;
        } else {
            $this->download_switch_warning = false;
        }
    }

    public function updatedCategory(): void
    {
        // Live update category as user changes it
        $this->video->category_id = $this->category;

    }


    public function render()
    {
        return view('livewire.edit.edit-presentation');
    }

    /** Helpers */
    private function formatTimestampForInput(int|string|null $timestamp): string
    {
        if (empty($timestamp)) {
            return now()->format('Y-m-d');
        }

        // Accept unix int or datetime string
        if (is_numeric($timestamp)) {
            return Carbon::createFromTimestamp((int) $timestamp)->format('Y-m-d');
        }

        return Carbon::parse($timestamp)->format('Y-m-d');
    }
}
