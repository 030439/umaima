<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BulkDataImport;
use Illuminate\Support\Facades\Redirect;

class BulkController extends Controller
{
    public function showImportForm()
    {
        return view('import.form'); // Create a view with the import form
    }

    public function import(Request $request)
    {
         $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
        Excel::import(new BulkDataImport, $request->file('file'));

         return Redirect::back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
          // Handle the error
            return Redirect::back()->with('error', 'Error importing data: ' . $e->getMessage());
        }


    }
}