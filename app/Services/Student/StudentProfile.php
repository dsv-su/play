<?php

namespace App\Services\Student;

use App\Services\Daisy\DaisyIntegration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class StudentProfile
{
    protected $daisy, $seconds;

    public function __construct(DaisyIntegration $daisy, $seconds)
    {
        $this->daisy = $daisy;
        $this->seconds = $seconds;
    }

    public function Student()
    {
        //Testing - fake students
        if (in_array(app()->make('play_role'), ['Student1', 'Student2', 'Student3'])) {
            if (app()->make('play_role') == 'Student1') {
                return [6442, 6841, 6761, 6837, 6703, 6839, 6708, 6838, 6769];
            } elseif (app()->make('play_role') == 'Student2') {
                return [6817, 6644, 6737, 6661, 6816, 6835, 6780, 6626, 6656, 6748, 6604, 6684, 6819, 6595, 6852];
            } elseif (app()->make('play_role') == 'Student3') {
                return [6798, 6799, 6760, 6778, 6828, 6796, 6719, 6720];
            }
        }
        //Student
        elseif (App::environment('production') &&
            (app()->make('play_auth') == 'Student' && (app()->make('play_role') == 'Uploader' or app()->make('play_role') == 'Student'))) {
            // User is Student store courses in cache
            return Cache::remember(app()->make('play_username'), $this->seconds, function () {
                return $this->daisy->getActiveStudentCourses(app()->make('play_username'));
            });
        }
        return [];
    }
}