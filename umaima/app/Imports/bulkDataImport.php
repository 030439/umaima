<?php

namespace App\Imports;

use App\Models\BulkModel;
use Maatwebsite\Excel\Concerns\ToModel;

class bulkDataImport implements ToModel
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
}
