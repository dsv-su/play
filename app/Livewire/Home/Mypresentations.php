<?php

namespace App\Livewire\Home;

use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Mypresentations extends Component
{
    /** @var array<int, \App\Models\Video> */
    public array $myvideos = [];

    public int $totalCount = 0;


    public function mount(MyPresentationsService $service, VisibilityFilter $visibility): void
    {
        $username = (string) app()->make('play_username');
        $authRole = (string) app()->make('play_auth');
        $playRole = (string) app()->make('play_role');

        $result = $service->getTopForUser($username, $authRole, $playRole, limit: 10);

        $this->myvideos   = $visibility->filter($result['videos'])->all();
        $this->totalCount = $result['total'];

    }



    /**
     * True if user is staff (any staff-like auth + role).
     */
    private function isStaff(string $authRole, string $playRole): bool
    {
        return in_array($authRole, self::STAFF_ROLES, true)
            && in_array($playRole, self::STAFF_ROLES, true);
    }

    /**
     * True if user is an administrator.
     */
    private function isAdmin(string $authRole, string $playRole): bool
    {
        return $authRole === 'Administrator' && $playRole === 'Administrator';
    }

    public function render(): View
    {
        return view('livewire.home.mypresentations');
    }
}

