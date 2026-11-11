<?php

namespace App\Livewire\Study;

use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;

class StudyPresentations extends PresentationLibraryResults
{
    public bool $allowBulkEdit = false;

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForStudy($filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.study.study-presentations';
    }
}
