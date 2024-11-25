<?php

namespace App\Http\Controllers;
use App\Services\UsersService;
use App\Services\SchemeService;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BulkDataImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index(SchemeService $schemeservice)
    {
        $totalPlotsSchemeWise = $schemeservice->totalPlotsSchemeWise();
        return view('dashboard.index', compact('totalPlotsSchemeWise'));
    }
    public function bulk(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);
        
        if ($validator->fails()) {
            $errorMessages = implode("\n", $validator->errors()->all());
            return response()->json([
                $errorMessages
            ], 400); // HTTP status code 400 for bad request
        }
    
        try {
            Excel::import(new BulkDataImport, $request->file('file'));
            return response()->json(["File uploaded successfully"
        ], 200);
           
        } catch (\Exception $e) {
            return response()->json(["Error"
        ], 400);
           
        }
    }
}
