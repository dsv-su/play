<?php

namespace App\Http\Livewire;

use App\CourseTag;
use App\Tag;
use Livewire\Component;

class Coursesetting extends Component
{
    public $course;
    public $coursesettings;
    public $downloadable, $download_switch_warning;
    public $tagids = [];
    public $ipermissions;
    public $user_permission;
    public $individuals = [], $individuals_permission = [];
    public $permissions, $permissonId, $permissonScope;

    public function mount($course, $coursesettings_permissions, $individual_permissions, $permissions, $user_permission)
    {
        $this->course = $course;

        if ($coursesettings_permissions) {
            //
            if($coursesettings_permissions->visibility) {
                $this->visibility = 'visible';
            } else {
                $this->visibility = 'private';
            }

            $this->downloadable = $coursesettings_permissions->downloadable;
            $this->ipermissions = $individual_permissions->count();

            //Unlisted
            if($coursesettings_permissions->unlisted) {
                $this->visibility = 'unlisted';
            }

        } else {
            $this->visibility = 'visible';
            $this->downloadable = false;
        }



        //Individual Permissions
        foreach ($this->course->userpermissions as $this->ip) {
            $this->individuals[] = $this->ip->name . ' (' . $this->ip->username . ')';
            $this->individuals_permission[] = $this->ip->permission;
        }

        //Current user permission;
        $this->user_permission = $user_permission;

        //Course tags
        foreach ($this->course->tags() as $tag) {
            $this->tagids[] = $tag->id;
        }

        //Group permissions
        $this->permissions = $permissions;
        foreach ($this->course->permissions() as $p) {
            $this->permissonId = $p->id;
            $this->permissonScope = $p->scope;
        }
    }

    public function updatedVisibility($state)
    {
        switch($state) {
            case('visible'):
                $this->visibility = 'visible';
                break;
            case('private'):
                $this->visibility = 'private';
                break;
            case('unlisted'):
                $this->visibility = 'unlisted';
                break;
        }
        //Set download to false if hidden
        if($this->visibility == 'private') {
            $this->download = false;
        } else {
            $this->download_switch_warning = false;
        }
    }

    public function downloadable()
    {
        //Follows the visibility setting -disabled
        /*if($this->visibility == 'visible') {
            $this->downloadable = !$this->downloadable;
        } else {
            $this->download_switch_warning = true;
            $this->downloadable = false;
        }*/
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

    public function add_tag($tagid)
    {
        if (!in_array($tagid, $this->tagids)) {
            $this->tagids[] = $tagid;
        }
    }

    public function create_tag($tagname)
    {
        $tag = Tag::firstOrCreate(['name' => $tagname]);
        $this->tagids[] = $tag->id;
    }

    public function remove_tag($index)
    {
        array_splice($this->tagids, $index, 1);
    }

    public function render()
    {
        return view('livewire.coursesetting');
    }
}
