<?php

namespace App\Livewire\My;

use Livewire\Component;
use App\Livewire\Concerns\DSVCourseNames;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Livewire\Concerns\HasSelectableFilters;
use Livewire\Attributes\On;

class MyPresentations extends Component
{
    use HasSelectableFilters, DSVCourseNames;

    public int $totalCount = 0;
    public bool $switchOn = false;
    public array $activeFilters = ['courses' => true, 'presenters' => true, 'semesters' => true, 'tags' => true];

    public function mount(MyPresentationsService $my, VisibilityFilter $visibility): void
    {
        $username = (string) app()->make('play_username');
        $authRole = (string) app()->make('play_auth');
        $playRole = (string) app()->make('play_role');

        $result = $my->getTopForUser($username, $authRole, $playRole, limit: 1000);
        $this->allVideos = $visibility->filter($result['videos']);
        $this->seedAllVideos($this->allVideos);
        $this->totalCount = (int) $result['total'];

        $this->recompute();
    }


    /*#[On('recompute')]
    public function handleRecompute(string $prop): void
    {
        $allowed = ['courses','presenters','semesters','tags'];
        if (!in_array($prop, $allowed, true)) return;
        $this->filters->selected[$prop] = [];
        $this->recompute();
    }*/

    public function toggleSelectAll($videos): void
    {
        $allIds = collect($videos)->pluck('id')->values()->all();
        $this->selectedVideos = ($this->selectedVideos === $allIds) ? [] : $allIds;
    }

    public function updatedSelectedVideos(): void
    {
        dd($this->selectedVideos);
    }

    public function bulkedit(): void
    {
        dd('Bulkedit');
    }

    public function render()
    {
        return view('livewire.my.my-presentations');
    }
}
