<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Coursesetting extends Component
{
    public $course;
    public $coursesettings;
    public $downloadable;
    public $ipermissions;
    public $user_permission;
    public $individuals = [], $individuals_permission = [];
    public $permissions, $permissonId, $permissonScope;

    public function mount($course, $coursesettings_permissions, $individual_permissions, $permissions, $user_permission)
    {
        $this->course = $course;
        if ($coursesettings_permissions) {
            $this->visibility = $coursesettings_permissions->visibility;
            $this->downloadable = $coursesettings_permissions->downloadable;
            $this->ipermissions = $individual_permissions->count();
        } else {
            $this->visibility = true;
            $this->downloadable = false;
        }

        //Individual Permissions
        foreach ($this->course->userpermissions as $this->ip) {
            $this->individuals[] = $this->ip->name . ' (' . $this->ip->username . ')';
            $this->individuals_permission[] = $this->ip->permission;
        }

        //Current user permission;
        $this->user_permission = $user_permission;

        //Group permissions
        $this->permissions = $permissions;
        foreach ($this->course->permissions() as $p) {
            $this->permissonId = $p->id;
            $this->permissonScope = $p->scope;
        }
    }

    public function visibility()
    {
        $this->visibility = !$this->visibility;
    }

    public function downloadable()
    {
        $this->downloadable = !$this->downloadable;
    }

    public function add_individual_perm()
    {
        array_push($this->individuals, '');
        array_push($this->individuals_permission, '');
        $this->ipermissions++;
        $this->dispatchBrowserEvent('permissionChanged');
    }

    public function remove_user($index)
    {
        array_splice($this->individuals, $index, 1);
        $this->ipermissions = $this->ipermissions - 1;
    }

    public function render()
    {
        return view('livewire.coursesetting');
    }
}
