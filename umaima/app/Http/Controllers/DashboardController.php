<?php

namespace App\Http\Controllers;
use App\Services\UsersService;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourDataImport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        return view('dashboard.index');
    }
    public function bulk(Request $request){
        {
            // Check if a file was uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Move the file to the 'uploads' folder in the public directory
                $file->move(public_path('uploads'), $filename);
                return response()->json(["Error"
                ], 400);
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded successfully',
                    'filename' => $filename
                ]);

            }
    
//sdfsdf

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);
        }
    }
}
