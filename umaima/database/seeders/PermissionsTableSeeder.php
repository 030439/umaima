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

            ['name' => 'scheme.read', 'guard_name' => 'web'],
            ['name' => 'scheme.write', 'guard_name' => 'web'],
            ['name' => 'scheme.create', 'guard_name' => 'web'],
            ['name' => 'scheme.delete', 'guard_name' => 'web'],

            ['name' => 'plot.read', 'guard_name' => 'web'],
            ['name' => 'plot.write', 'guard_name' => 'web'],
            ['name' => 'plot.create', 'guard_name' => 'web'],
            ['name' => 'plot.delete', 'guard_name' => 'web'],

            ['name' => 'allote.read', 'guard_name' => 'web'],
            ['name' => 'allote.write', 'guard_name' => 'web'],
            ['name' => 'allote.create', 'guard_name' => 'web'],
            ['name' => 'allote.delete', 'guard_name' => 'web'],

            ['name' => 'allotment.read', 'guard_name' => 'web'],
            ['name' => 'allotment.write', 'guard_name' => 'web'],
            ['name' => 'allotment.create', 'guard_name' => 'web'],
            ['name' => 'allotment.delete', 'guard_name' => 'web'],

            ['name' => 'schedule.read', 'guard_name' => 'web'],
            ['name' => 'schedule.write', 'guard_name' => 'web'],
            ['name' => 'schedule.create', 'guard_name' => 'web'],
            ['name' => 'schedule.delete', 'guard_name' => 'web'],

            ['name' => 'bank.read', 'guard_name' => 'web'],
            ['name' => 'bank.write', 'guard_name' => 'web'],
            ['name' => 'bank.create', 'guard_name' => 'web'],
            ['name' => 'bank.delete', 'guard_name' => 'web'],

            ['name' => 'payment.read', 'guard_name' => 'web'],
            ['name' => 'payment.write', 'guard_name' => 'web'],
            ['name' => 'payment.create', 'guard_name' => 'web'],
            ['name' => 'payment.delete', 'guard_name' => 'web'],

            ['name' => 'voucher.read', 'guard_name' => 'web'],
            ['name' => 'voucher.write', 'guard_name' => 'web'],
            ['name' => 'voucher.create', 'guard_name' => 'web'],
            ['name' => 'voucher.delete', 'guard_name' => 'web'],

            ['name' => 'ledger.read', 'guard_name' => 'web'],
            ['name' => 'ledger.write', 'guard_name' => 'web'],
            ['name' => 'ledger.create', 'guard_name' => 'web'],
            ['name' => 'ledger.delete', 'guard_name' => 'web'],

            ['name' => 'account-head.read', 'guard_name' => 'web'],
            ['name' => 'account-head.write', 'guard_name' => 'web'],
            ['name' => 'account-head.create', 'guard_name' => 'web'],
            ['name' => 'account-head.delete', 'guard_name' => 'web'],

            ['name' => 'invoice.read', 'guard_name' => 'web'],
            ['name' => 'invoice.write', 'guard_name' => 'web'],
            ['name' => 'invoice.create', 'guard_name' => 'web'],
            ['name' => 'invoice.delete', 'guard_name' => 'web'],

            ['name' => 'permissions.read', 'guard_name' => 'web'],
            ['name' => 'permissions.list', 'guard_name' => 'web'],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        DB::table('plot_categories')->insert([
            'id' => 1,
            'category_name'=>"Commercial"
        ]);
        DB::table('plot_categories')->insert([
            'id' => 2,
            'category_name'=>"Residentail"
        ]);

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
