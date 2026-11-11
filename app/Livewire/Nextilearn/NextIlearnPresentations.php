<?php

namespace App\Livewire\Nextilearn;

use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;

class NextIlearnPresentations extends PresentationLibraryResults
{
    public bool $allowBulkEdit = false;

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForNextIlearn($filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.nextilearn.next-ilearn-presentations';
    }
}
