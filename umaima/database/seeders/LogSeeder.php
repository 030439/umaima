<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogSeeder extends Seeder
{
    public function run()
    {
        DB::table('logs')->insert([
            [
                'user_id' => 1,
                'action' => 'Create Plot',
                'details' => 'Plot ID: 1001, Plot Number: P-101 created in Scheme A',
                'ip_address' => '192.168.1.1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'action' => 'Update Plot Details',
                'details' => 'Plot ID: 1002, Plot Number: P-102 updated in Scheme B',
                'ip_address' => '192.168.1.2',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 1,
                'action' => 'User Login',
                'details' => 'User ID: 1 logged in',
                'ip_address' => '192.168.1.3',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'user_id' => 3,
                'action' => 'Delete Plot',
                'details' => 'Plot ID: 1003, Plot Number: P-103 deleted from Scheme C',
                'ip_address' => '192.168.1.4',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 1,
                'action' => 'View Plot Details',
                'details' => 'Plot ID: 1004, Plot Number: P-104 viewed in Scheme D',
                'ip_address' => '192.168.1.1',
                'created_at' => Carbon::now()->subMinutes(10),
                'updated_at' => Carbon::now()->subMinutes(10),
            ],
            // Add more records if needed
        ]);
    }
}
