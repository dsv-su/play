<?php

namespace App\Livewire\Upload;

use App\Models\Category;
use App\Models\ManualPresentation;
use Carbon\Carbon;
use Livewire\Component;

class UploadMeta extends Component
{
    public ?ManualPresentation $presentation = null;

    /** UI fields */
    public string $date = '';                 // yyyy-mm-dd for inputs

    public array $categories = [];            // collection->toArray()

    public ?int $category = null;             // selected category id

    /** Visibility */
    public string $visibility = 'visible';    // 'visible' | 'private' | 'unlisted'

    public bool $download = false;

    public bool $download_switch_warning = false;

    public function mount($presentation = null)
    {
        if ($presentation) {
            $this->presentation = $presentation;
        }
        $this->date = $this->formatTimestampForInput();
        $this->categories = Category::query()->orderBy('category_name')->get(['id', 'category_name'])->toArray();
        $this->category = $this->presentation?->category_id ?? 1;
    }

    public function render()
    {
        return view('livewire.upload.upload-meta');
    }

    /** Helpers */
    private function formatTimestampForInput(int|string|null $timestamp = null): string
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
