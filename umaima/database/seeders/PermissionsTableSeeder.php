<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // Ensure the User model is imported

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            ['name' => 'user_read', 'guard_name' => 'web'],
            ['name' => 'user_write', 'guard_name' => 'web'],
            ['name' => 'user_create', 'guard_name' => 'web'],
            ['name' => 'user_delete', 'guard_name' => 'web'],

            ['name' => 'role_read', 'guard_name' => 'web'],
            ['name' => 'role_write', 'guard_name' => 'web'],
            ['name' => 'role_create', 'guard_name' => 'web'],
            ['name' => 'role_delete', 'guard_name' => 'web'],

            ['name' => 'api_read', 'guard_name' => 'web'],
            ['name' => 'api_write', 'guard_name' => 'web'],
            ['name' => 'api_create', 'guard_name' => 'web'],
            ['name' => 'api_delete', 'guard_name' => 'web'],

            ['name' => 'payroll_read', 'guard_name' => 'web'],
            ['name' => 'payroll_write', 'guard_name' => 'web'],
            ['name' => 'payroll_create', 'guard_name' => 'web'],
            ['name' => 'payroll_delete', 'guard_name' => 'web'],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Create admin role and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Create a new admin user and assign the admin role

      


        $user = User::firstOrCreate(
            ['email' => 'info@admin.com'],
            [
                'fname' => 'admin',
                'lname'=>"admin",
                'status'=>true,
                'username' => 'admin',
                'password' => bcrypt('info123'), // Encrypt password
            ]
        );

        // Attach the role to the user
        $user->assignRole($adminRole);
    }
}
