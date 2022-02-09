<?php

namespace App\Http\Livewire;

use App\CourseadminPermission;
use App\Http\Middleware\Localization;
use App\Services\Daisy\DaisyIntegration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EditPresentation extends Component
{
    //use WithFileUploads;

    public $video;
    public $title, $thumb, $created, $date, $origin, $duration, $category, $description;
    public $presenters = [], $presenters_uid = [];
    public $course = [], $coursedetail = [], $course_semester = [], $course_year = [], $courseId = [];
    public $courseids;
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
    public $download;
    public $user_permission;

    public function mount($video, $courses, $permissions, $individual_permissions, $user_permission)
    {
        $this->video = $video;
        $this->title = $video->title;
        $this->thumb = $video->thumb;
        $this->origin = $video->origin;
        $this->duration = $video->duration;
        $this->description = $video->description;
        $this->date = $this->getDateAttribute($video->creation);
        $this->permissions = $permissions;
        $this->category = $video->category->category_name;
        $this->sources = $video->streams;
        $this->ipermissions = $individual_permissions->count();
        $this->visibility = (bool)$video->visibility;
        $this->download = (bool)$video->download;
        $this->user_permission = $user_permission;

        foreach ($video->presenters() as $presenter) {
            if (!$presenter->username == null) {
                $this->presenters[] = $presenter->name . ' (' . $presenter->username . ')';
            } else {
                $this->presenters[] = $presenter->name;
            }
            $this->presenters_uid[] = $presenter->username;
        }

        foreach ($video->courses() as $this->coursedetail) {
            if(Lang::locale() == 'swe') {
                $this->course[] = $this->coursedetail->name . ' ' . $this->coursedetail->semester . '' . $this->coursedetail->year;
            } else {
                $this->course[] = $this->coursedetail->name_en . ' ' . $this->coursedetail->semester . '' . $this->coursedetail->year;
            }

            $this->courseId[] = $this->coursedetail->id;
            $this->course_semester[] = $this->coursedetail->semester;
            $this->course_year[] = $this->coursedetail->year;
            foreach ($this->coursedetail->responsible() as $person) {
                $this->course_responsible[$this->coursedetail->id][] = $person;
            }
            // Add existing courses even if a person has no permission
            if(Lang::locale() == 'swe') {
                $this->courseselect[$this->coursedetail->id] = [$this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year . ' (' . $this->coursedetail->name . ')', $this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year];
            } else {
                $this->courseselect[$this->coursedetail->id] = [$this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year . ' (' . $this->coursedetail->name_en . ')', $this->coursedetail->designation . ' ' . $this->coursedetail->semester . $this->coursedetail->year];
            }

        }

        $this->courseids = json_encode($this->courseId, JSON_HEX_QUOT);

        foreach ($video->tags() as $tag) {
            $this->tagids[] = $tag->id;
        }
        $this->tagids = json_encode($this->tagids, JSON_HEX_QUOT);

        foreach ($courses as $data) {
            if(Lang::locale() == 'swe') {
                $this->courseselect[$data->id] = [$data->designation . ' ' . $data->semester . $data->year . ' (' . $data->name . ')', $data->designation . ' ' . $data->semester . $data->year];
            } else {
                $this->courseselect[$data->id] = [$data->designation . ' ' . $data->semester . $data->year . ' (' . $data->name_en . ')', $data->designation . ' ' . $data->semester . $data->year];
            }

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
        array_push($this->individuals, '');
        array_push($this->individuals_permission, '');
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
    function newpresenter()
    {
        array_push($this->presenters, '');
        array_push($this->presenters_uid, '');
        $this->dispatchBrowserEvent('contentChanged');
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

    public
    function remove_course()
    {
        $this->course = '';
    }

    public
    function render()
    {
        return view('livewire.edit-presentation');
    }
}
