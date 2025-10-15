<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $file = base_path().'/systemconfig/play.ini';
        if (!file_exists($file)) {
            $file = base_path().'/systemconfig/play.ini.example';
        }
        $system_config = parse_ini_file($file, true);

        DB::table('users')->insert([
            'name' => 'ConversionServer',
            'email' => $system_config['api']['email'],
            'password' => Hash::make($system_config['api']['password']),
        ]);
        DB::table('users')->insert([
            'name' => 'TicketHandler',
            'email' => $system_config['ticket']['email'],
            'password' => Hash::make($system_config['ticket']['password']),
        ]);
    }
}
