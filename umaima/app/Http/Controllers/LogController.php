<?php
namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }
}
