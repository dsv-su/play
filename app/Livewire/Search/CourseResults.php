<?php

namespace App\Livewire\Search;

use App\Livewire\PresentationLibraryResults;
use App\Services\MyPresentation\PresentationLibrary;
use App\Services\VideoSearch\VideoFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;

class CourseResults extends PresentationLibraryResults
{
    #[Locked]
    public string $designation = '';

    public bool $allowBulkEdit = false;

    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];

    public function mount(string $designation = ''): void
    {
        $this->designation = $designation;
        parent::mount();
    }

    protected function libraryQuery(PresentationLibrary $library, VideoFilters $filters): Builder
    {
        return $library->queryForCourse($this->designation, $filters);
    }

    protected function resultsView(): string
    {
        return 'livewire.search.course-results';
    }
}
