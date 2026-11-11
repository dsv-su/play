<?php

namespace App\Livewire\Search;

use App\Livewire\Concerns\DSVPresenters;
use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;

class PresenterResults extends PresentationLibraryResults
{
    use DSVPresenters;

    #[Locked]
    public string $presenter_search = '';

    public bool $allowBulkEdit = false;

    public array $activeFilters = ['courses' => true, 'presenters' => false, 'semesters' => true, 'tags' => true];

    public function mount(string $presenter_search = ''): void
    {
        $this->presenter_search = $presenter_search;
        parent::mount();
    }

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForPresenter($this->presenter_search, $filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.search.presenter-results';
    }
}
