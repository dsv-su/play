<?php

namespace App\Livewire\Search;

use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;

class TagResults extends PresentationLibraryResults
{
    #[Locked]
    public string $tagName = '';

    public bool $allowBulkEdit = false;

    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => false];

    public function mount(string $tag = ''): void
    {
        $this->tagName = $tag;
        parent::mount();
    }

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForTag($this->tagName, $filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.search.tag-results';
    }
}
