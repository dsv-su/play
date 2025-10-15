<?php

namespace App\Livewire\Edit;

use App\Services\Daisy\DaisyIntegration;
use Livewire\Component;

class CourseResponsible extends Component
{
    public array $selectedCourses = [];
    public array $courseResponsible = [];
    protected DaisyIntegration $daisy;

    protected $rules = [
        'selectedCourses' => 'array',
        'selectedCourses.*' => 'integer',
    ];


    public function updatedSelectedCourses(DaisyIntegration $daisy): void
    {
        $this->courseResponsible = [];

        foreach ($this->selectedCourses as $courseID) {
            $this->courseResponsible[$courseID] = $daisy->getDaisyCourseResponsible($courseID);
        }

        // remove duplicates in *values*
        //$this->courseResponsible = array_unique($this->courseResponsible, SORT_REGULAR);
    }


    public function render()
    {
        return view('livewire.edit.course-responsible');
    }
}
