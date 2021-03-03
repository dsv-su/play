<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name' => 'Okategoriserad',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Databas',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Operativsystem',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Programmering',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Testing',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Matematik',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'IT Säkerhet',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        /*
        DB::table('categories')->insert([
            'category_name' => '',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        */
    }
}
