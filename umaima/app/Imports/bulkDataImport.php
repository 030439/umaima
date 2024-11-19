<?php

namespace App\Imports;

use App\Models\BulkModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class BulkDataImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BulkModel([
            //
        ]);
    }
    public function collection(Collection $rows)
    {
        // Skip the header row
        $rows->shift();

        // Use a database transaction to ensure consistency
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Insert into Users table
                $user = User::create([
                    'name' => $row[0], // Assuming 'user_name' is in column 0
                    'email' => $row[1], // 'email' in column 1
                    'phone' => $row[3], // 'phone' in column 3
                ]);

                // Insert into Addresses table using the `user_id`
                Address::create([
                    'user_id' => $user->id,
                    'address' => $row[2], // 'address' in column 2
                ]);
            }
        });
    }
}
