<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PlotController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions.index');
    Route::get('/permissions-list', [RolePermissionController::class, 'permissionsList'])->name('permissions.list');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
// });
// plost setupt routes in group with prefix
    Route::controller(PlotController::class)
        ->prefix('setup')
        ->group(function(){
            Route::get('plot-size','plotSize')->name('plot.size');
            Route::get('plot-location','plotLocation')->name('plot.location');
    });

require __DIR__.'/auth.php';
