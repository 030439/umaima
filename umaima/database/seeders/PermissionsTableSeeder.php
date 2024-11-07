<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'user_management_read', 'guard_name' => 'web'],
            ['name' => 'user_management_write', 'guard_name' => 'web'],
            ['name' => 'user_management_create', 'guard_name' => 'web'],
            ['name' => 'user_management_delete', 'guard_name' => 'web'],

            ['name' => 'role_read', 'guard_name' => 'web'],
            ['name' => 'role_write', 'guard_name' => 'web'],
            ['name' => 'role_create', 'guard_name' => 'web'],
            ['name' => 'role_delete', 'guard_name' => 'web'],

            ['name' => 'api_read', 'guard_name' => 'web'],
            ['name' => 'api_write', 'guard_name' => 'web'],
            ['name' => 'api_create', 'guard_name' => 'web'],
            ['name' => 'api_delete', 'guard_name' => 'web'],

        ];

        DB::table('permissions')->insert($permissions);
    }
}
