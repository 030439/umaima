<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::post('/fetch-roles', [RolePermissionController::class, 'getRoles'])->name('roles.fetch');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions.index');
    Route::get('/permissions-list', [RolePermissionController::class, 'permissionsList'])->name('permissions.list');
    Route::get('/permissions-listing', [RolePermissionController::class, 'getPermissions'])->name('permissions.listing');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::post('/assign-role', [RolePermissionController::class, 'assignRole'])->name('roles.assign');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('user-register', [RegisteredUserController::class, 'saveUser']);
// });
require __DIR__.'/auth.php';
