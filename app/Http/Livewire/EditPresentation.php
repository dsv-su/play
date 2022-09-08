<?php

namespace App\Http\Livewire;

use App\Course;
use App\CourseadminPermission;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Ldap\SukatUser;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EditPresentation extends Component
{
    public $video;
    public $title, $title_en, $thumb, $created, $date, $origin, $duration, $category, $description;
    public $presenters = [], $presenters_uid = [];
    public $presenterids = [];
    public $course = [], $coursedetail = [], $courseId = [];
    public $courseids = [];
    public $courseselect = [];
    public $sukatusers = [];
    public $courseEdit = [];
    public $tags, $tagids = [];
    public $permissions, $presentationpermissonId, $presentationpermissonScope;
    public $sources = [], $playAudio = [], $poster = [], $hidden = [];
    public $ipermissions, $ip;
    public $individuals = [], $individuals_permission = [];
    public $i = 0;
    public $suser;
    public $course_responsible = [];
    public $visibility;
    public $download, $download_switch_warning;
    public $user_permission;

    public function mount($video, $permissions, $individual_permissions, $user_permission)
    {
        $this->video = $video;
        $this->title = $video->title;
        $this->title_en = $video->title_en;
        $this->thumb = $video->thumb;
        $this->origin = $video->origin;
        $this->duration = $video->duration;
        $this->description = $video->description;
        $this->date = $this->getDateAttribute($video->creation);
        $this->permissions = $permissions;
        $this->category = $video->category->category_name;
        $this->sources = $video->streams;
        $this->ipermissions = $individual_permissions->count();
        $this->download_switch_warning = false;

        if (!$video->visibility) {
            $this->download = false;
        } else {
            $this->visibility = (bool)$video->fresh()->visibility;
            $this->download = (bool)$video->download;
        }

        $this->user_permission = $user_permission;

        foreach ($video->presenters() as $presenter) {
            $role = null;
            if ($presenter->username) {
                $su = SukatUser::where('uid', $presenter->username)->first();
                if (!empty($su->edupersonentitlement)) {
                    if (in_array('urn:mace:swami.se:gmai:dsv-user:staff', $su->edupersonentitlement)) {
                        $role = 'DSV';
                    } elseif (in_array('urn:mace:swami.se:gmai:dsv-user:student', $su->edupersonentitlement)) {
                        $role = 'Student';
                    }
                }
            }
            $this->presenters[] = ['uid' => $presenter->username, 'name' => $presenter->name, 'type' => $presenter->description, 'role' => $role];
        }

        /*
        foreach ($video->courses() as $this->coursedetail) {
            $this->courseId[] = $this->coursedetail->id;
            $this->course_semester[] = $this->coursedetail->semester;
            $this->course_year[] = $this->coursedetail->year;
            foreach ($this->coursedetail->responsible() as $person) {
                $this->course_responsible[$this->coursedetail->id][] = $person;
            }
            // Add existing courses even if a person has no permission
            if (Lang::locale() == 'swe') {
                $this->courseselect[$this->coursedetail->id] = [$this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year, $this->coursedetail->name];
            } else {
                $this->courseselect[$this->coursedetail->id] = [$this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year, $this->coursedetail->name_en];
            }
        }*/
        foreach ($video->courses() as $this->coursedetail) {
            $name = (Lang::locale() == 'swe') ? $this->coursedetail->name : $this->coursedetail->name_en;
            $this->course[] = $name . ' ' . $this->coursedetail->semester . $this->coursedetail->year;
            $this->courseids[$this->coursedetail->id] = ['fullname' => $name, 'shortname' => $this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year];
        }

        foreach ($video->tags() as $tag) {
            $this->tagids[] = $tag->id;
        }

        //Group Permissions
        foreach ($video->permissions() as $p) {
            $this->presentationpermissonId = $p->id;
            $this->presentationpermissonScope = $p->scope;
        }

        //Individual Permissions
        foreach ($video->ipermissions as $this->ip) {
            $this->individuals[] = $this->ip->name . ' (' . $this->ip->username . ')';
            $this->individuals_permission[] = $this->ip->permission;
        }

        //Streams
        foreach ($video->streams as $source) {
            $this->playAudio[] = $source->audio;
            $this->hidden[] = $source->hidden;
            $this->poster[] = $this->base_uri() . '/' . $video->id . '/' . $source->poster;
        }
    }

    public function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    public function visibility()
    {
        //Toggles the img and presentation_hidden text
        $this->visibility = !$this->visibility;
        //Set download to false if hidden
        if(!$this->visibility) {
            $this->download = false;
        } else {
            $this->download_switch_warning = false;
        }
    }

    public function downloadability()
    {
        //Follows the visibility setting
        if($this->visibility) {
            $this->download = !$this->download;
        } else {
            $this->download_switch_warning = true;
            $this->download = false;
        }

    }

    public function updatedCourseEdit($value)
    {
        $daisy = new DaisyIntegration();
        // Remove current responsibles before pushing new ones:
        $this->course_responsible = [];

        foreach ($value as $v) {
            $this->course_responsible[] = $daisy->getDaisyCourseResponsible($v);
        }

        //This is for retriving the username -> until the endpoint in daisy has been revised
        foreach ($this->course_responsible as $courseid => $course_responsible) {
            foreach ($course_responsible as $key => $responsible) {
                $usernames = $daisy->getDaisyUsername($responsible['id']);
                foreach ($usernames as $username) {
                    if ($username['realm'] == 'SU.SE') {
                        $course_resp_username[] = $username['username'];
                    }
                }
                $firstnames[] = $responsible['firstName'];
                $lastnames[] = $responsible['lastName'];
            }
        }

        //Update coursePermissions
        //First delete old courseadmins
        CourseadminPermission::where('video_id', $this->video->id)->delete();

        //Update CourseadminPersmission with new courseadmins
        if ($course_resp_username ?? '') {
            foreach ($course_resp_username as $key => $usrn) {
                $cperm = CourseadminPermission::updateOrCreate(['video_id' => $this->video->id,
                    'username' => $usrn], ['name' => $firstnames[$key] . ' ' . $lastnames[$key],
                    'permission' => 'delete']);
            }
        }

    }

    public
    function updatedIndividuals($value)
    {
        //Checks if input is a valid sukat user
        //Not implemented
        $this->suser = preg_filter("/[^(]*\(([^)]+)\)[^()]*/", "$1", $value);
    }

    public
    function add_individual_perm()
    {
        $this->individuals[] = '';
        $this->individuals_permission[] = '';
        $this->ipermissions++;
        $this->dispatchBrowserEvent('permissionChanged');
    }

    public
    function getDateAttribute($date)
    {
        $this->date = Carbon::createFromTimestamp($date)->format('d/m/Y');
        return $this->date;
    }

    public
    function add_presenter($uid, $name)
    {
        if (!count(array_filter($this->presenters, function ($item) use ($uid, $name) {
            return $item['uid'] == $uid && $item['name'] = $name;
        }))) {
            $role = null;
            if ($uid) {
                $su = SukatUser::where('uid', $uid)->first();
                if (!empty($su->edupersonentitlement)) {
                    if (in_array('urn:mace:swami.se:gmai:dsv-user:staff', $su->edupersonentitlement)) {
                        $role = 'DSV';
                    } elseif (in_array('urn:mace:swami.se:gmai:dsv-user:student', $su->edupersonentitlement)) {
                        $role = 'Student';
                    }
                }
            }
            $this->presenters[] = ['uid' => $uid, 'name' => $name, 'type' => $uid ? 'sukat' : 'external', 'role' => $role];
        }
    }

    public
    function remove_presenter($index)
    {
        array_splice($this->presenters, $index, 1);
    }

    public
    function remove_user($index)
    {
        array_splice($this->individuals, $index, 1);
        $this->ipermissions = $this->ipermissions - 1;
    }

    public function add_course($courseid)
    {
        if (!key_exists($courseid, $this->courseids)) {
            $course = Course::find($courseid);
            $this->courseids[$courseid] = [
                'fullname' => (Lang::locale() == 'swe') ? $course->name : $course->name_en,
                'shortname' => $course->designation . ' ' . $course->semester . $course->year
            ];
        }
        $this->updatedCourseEdit(array_keys($this->courseids));
    }

    public function remove_course($courseid)
    {
        unset($this->courseids[$courseid]);
        $this->updatedCourseEdit(array_keys($this->courseids));
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

    public
    function render()
    {
        return view('livewire.edit-presentation');
    }
}
