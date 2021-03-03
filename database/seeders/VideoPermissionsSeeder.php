<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'scope' => 'Studenter och personal (DSV)',
            'entitlement' => 'urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student',
        ]);
        DB::table('permissions')->insert([
            'scope' => 'Endast personal (DSV)',
            'entitlement' => 'urn:mace:swami.se:gmai:dsv-user:staff',
        ]);
        DB::table('permissions')->insert([
            'scope' => 'Test X',
            'entitlement' => 'urn:mace:swami.se:gmai:dsv-user:secret',
        ]);
    }
}
