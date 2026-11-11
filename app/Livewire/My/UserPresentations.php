<?php

namespace App\Livewire\My;

use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;

class UserPresentations extends PresentationLibraryResults
{
    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->query($filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.my.my-presentations';
    }
}
