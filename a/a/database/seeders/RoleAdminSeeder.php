<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_admin')->insert([
            [
                'role_id' => 1,
                'admin_id' => 1
            ]
        ]);
    }
}
