<?php

namespace App\Http\Controllers;
use App\Services\UsersService;
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
    public function bulk(){
        return "0";
    }
}
