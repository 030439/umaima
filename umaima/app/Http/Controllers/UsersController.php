<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;

class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index()
    {
        return view('users.index');
    }
    
}
