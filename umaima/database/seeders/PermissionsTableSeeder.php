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
            ['name' => 'user.read', 'guard_name' => 'web'],
            ['name' => 'user.write', 'guard_name' => 'web'],
            ['name' => 'user.create', 'guard_name' => 'web'],
            ['name' => 'user.delete', 'guard_name' => 'web'],

            ['name' => 'roles.read', 'guard_name' => 'web'],
            ['name' => 'roles.write', 'guard_name' => 'web'],
            ['name' => 'roles.create', 'guard_name' => 'web'],
            ['name' => 'roles.delete', 'guard_name' => 'web'],

            ['name' => 'api.read', 'guard_name' => 'web'],
            ['name' => 'api.write', 'guard_name' => 'web'],
            ['name' => 'api.create', 'guard_name' => 'web'],
            ['name' => 'api.delete', 'guard_name' => 'web'],

            ['name' => 'payroll.read', 'guard_name' => 'web'],
            ['name' => 'payroll.write', 'guard_name' => 'web'],
            ['name' => 'payroll.create', 'guard_name' => 'web'],
            ['name' => 'payroll.delete', 'guard_name' => 'web'],

            ['name' => 'permissions.read', 'guard_name' => 'web'],
            ['name' => 'permissions.list', 'guard_name' => 'web'],
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
