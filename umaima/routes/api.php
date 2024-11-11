<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\AlloteController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/sign-in', [UsersController::class, 'apiLogin']);

Route::middleware(['auth:sanctum','access'])->group(function () {
    // roles routes
    Route::post('/roles-read', [RolePermissionController::class, 'getRoles'])->name('roles.read');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.create');
    // Users management route
    Route::post('/users', [UsersController::class, 'Listing'])->name('user.read');
    Route::post('user-create', [RegisteredUserController::class, 'saveUser'])->name('user.create');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::get('/permissions-listing', [RolePermissionController::class, 'getPermissions'])->name('permissions.read');
    Route::post('/assign-role', [RolePermissionController::class, 'assignRole'])->name('roles.assign');
    Route::post('/create-scheme', [SchemeController::class, 'store'])->name('scheme.create');
    Route::post('/schemes', [SchemeController::class, 'listing'])->name('scheme.read');
    Route::post('/create-scheme-plot', [PlotController::class, 'store'])->name('plot.create');
    Route::post('/plots', [PlotController::class, 'listing'])->name('plot.read');
    Route::post("create-allote",[AlloteController::class,'store'])->name('allote.create');
});
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/get-scheme-details', [SchemeController::class, 'getSchemeDetails']);
    Route::post('/get-user', [UsersController::class, 'getUser'])->name('user.get');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

