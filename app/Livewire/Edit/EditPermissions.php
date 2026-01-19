<?php

namespace App\Livewire\Edit;

use App\Models\IndividualPermission;
use App\Models\Video;
use App\Services\Directory\SearchPresenters;
use Illuminate\Support\Str;
use Livewire\Component;

class EditPermissions extends Component
{
    public ?Video $video = null;
    public string $searchP = '';
    public $permissions;
    public array $permissionsID = [];
    public $playback;
    public array $sukatUsers = [];
    public int $highlighted = 0;
    public array $individualPermissions = [];
    public $user_permission;
    public int $iPCount;

    public function boot(SearchPresenters $search)
    {
        $this->searchService = $search;
    }

    public function mount($video = null, $permissions, $user_permission)
    {
        if ($video) {
            $this->video = $video;
        }
        $this->permissions = $permissions;
        $this->user_permission = $user_permission;
        $this->getPermissionsID();
        //Load individual permissions for video
        $this->getIndividualPermissions();

        if ($this->searchP !== '') {
            $this->sukatUsers = $this->searchService->execute($this->searchP, 10, false);
        }
    }

    public function getIndividualPermissions()
    {
        if($this->video?->exists) {
            $this->individualPermissions = $this->video->individualPermissions->toArray();
            $this->iPCount = $this->video->individualPermissions->count();
        }
    }

    public function updatedSearchP(): void
    {
        $this->sukatUsers = $this->searchService->execute($this->searchP, 10, false);
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
            $this->addPermission($user->uid, $user->name);
        }
    }

    public function getPermissionsID()
    {
        $this->permissionsID = $this->permissions->pluck('id')->all();
        if($this->video?->exists) {
            foreach ($this->video->permissions as $p) {
                $this->playback = $p->id;
            }
        }
    }

    public function updatedPlayback($value)
    {
        $this->playback = $value;
    }

    public function addPermission($Uid, $name)
    {
        $this->individualPermissions[] =  ['username' => $Uid, 'name' => $name, 'permission' => 'read'];
        $this->searchP = '';
    }

    public function setPermission($key, $value): void
    {
        $current = $this->individualPermissions[$key]['permission'] ?? null;

        if (!in_array($value, ['read', 'edit', 'delete'], true)) {
            return;
        }

        // "delete" users can change anything
        if ($this->user_permission === 'delete') {
            $this->individualPermissions[$key]['permission'] = $value;
            return;
        }

        // restrictions for everyone else
        if ($current === 'edit' && $value === 'delete') return;
        if ($current === 'read' && $value === 'edit') return;
        // optional stricter:
        // if ($current === 'read' && $value === 'delete') return;

        $this->individualPermissions[$key]['permission'] = $value;
    }

    public function remove_user($index)
    {
        array_splice($this->individualPermissions, $index, 1);
        //$this->ipermissions = $this->ipermissions - 1;
    }

    public function render()
    {
        return view('livewire.edit.edit-permissions');
    }
}
