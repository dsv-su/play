<?php

namespace App\Livewire\Admin;

use App\Services\Directory\SearchPresenters;
use Livewire\Component;

class CustomInput extends Component
{
    public string $searchUser = '';
    /** @var array<int, array{uid:int|string, name:string, role:string, local:bool}> */
    public array $sukatUsers = [];
    public int $highlighted = 0;

    public function boot(SearchPresenters $search)
    {
        $this->searchService = $search;
    }

    public function moveHighlight(int $direction): void
    {
        $count = count($this->sukatUsers);
        if ($count === 0) return;

        $this->highlighted = ($this->highlighted + $direction + $count) % $count;
    }

    public function addHighlighted(): void
    {
        if (isset($this->sukatUsers[$this->highlighted])) {
            $user = $this->sukatUsers[$this->highlighted];
            $this->addUser($user->uid, $user->name);
        }
    }

    public function updatedSearchUser(): void
    {
        $this->sukatUsers = $this->searchService->execute($this->searchUser);
    }

    public function addUser($uid, $name)
    {
        $this->searchUser = $uid;
    }

    public function render()
    {
        return view('livewire.admin.custom-input', [
            'searchPresenter' => $this->searchUser,
        ]);
    }
}
