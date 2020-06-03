<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory('App\Category', 10)->create();
        DB::table('categories')->insert([
            'category_name' => 'Databas',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Programmering',
            'created_at' =>  Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
