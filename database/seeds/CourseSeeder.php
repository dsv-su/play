<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'course_name' => 'Databasmetodik',
            'semester' => 'HT',
            'year' => '2016',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('courses')->insert([
            'course_name' => 'Programmering 1',
            'semester' => 'HT',
            'year' => '2018',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('courses')->insert([
            'course_name' => 'Testcourse',
            'semester' => 'VT',
            'year' => '2020',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('courses')->insert([
            'course_name' => 'Diskret matematik',
            'semester' => 'VT',
            'year' => '2015',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('courses')->insert([
            'course_name' => 'FMVEK',
            'semester' => '??',
            'year' => '20??',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('courses')->insert([
            'course_name' => 'KM - Kunskapsnätverk',
            'semester' => 'HT',
            'year' => '2015',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        /*
        DB::table('courses')->insert([
            'course_name' => '',
            'semester' => '',
            'year' => '',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        */
    }
}
