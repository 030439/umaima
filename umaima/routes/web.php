<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\AlloteController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LogController;
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

Route::get("clearData",function(){
    \Artisan::call('cache:clear');
     \Artisan::call('route:clear');
     \Artisan::call('config:cache');
           \Artisan::call('optimize:clear');
       return "Route cache cleared successfully!"; 
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');
    Route::post('upload/bilk',[DashboardController::class,'bulk'])->name('bulk.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions.index');
    Route::get('/permissions-list', [RolePermissionController::class, 'permissionsList'])->name('permissions.list');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('scheme-plots/{id}',[SchemeController::class,'schemeWisePlot'])->name('plot-read');
    Route::get('/alloted-plots/scheme/{id}',[SchemeController::class,'allotePlotByScheme'])->name('plot-read');
    
   
});
// plost setupt routes in group with prefix
Route::middleware('auth')->group(function () {
    Route::controller(AccountController::class)
    ->group(function(){
        Route::get('payment-detail/{id}','paymentDetail');
    });
    Route::controller(PlotController::class)
        ->prefix('setup')
        ->group(function(){
            Route::get('plot-size','plotSize')->name('plot.size');
            Route::get('plot-location','plotSize')->name('plot.location');
            Route::get('plot.installments','installments')->name('plot.installments');
            Route::post('create-plot-location','createPlotLocation');
            Route::post('create-plot-category','createPlotCategory');
            Route::post('create-plot-size','createPlotSize');
            Route::post('duration','duration');
            Route::post('installment','installment');
            Route::get('plot-alltment','plotAllotment')->name('allotment.form');
    });

    Route::controller(SchemeController::class)
        ->group(function(){
            Route::get('scheme-listing','index')->name('scheme.index');
            Route::get('create-scheme','createScheme')->name('scheme.add');
            Route::get('scheme-plots','schemePlots')->name('scheme.plots');
            Route::get('plots','schemePlots');
            Route::get('add-scheme-plot','createSchemePlot')->name('scheme.plot');
            Route::get('alloted-plot-listing','allotedPlotListing')->name('alloted.index');
    });
    Route::controller(AlloteController::class)
    ->group(function(){
        Route::get('allote-listing','index')->name('allote.index');
        Route::get('create-allote','alloteCreate');
        Route::POST('edit-allote','editStore')->name('allote.edit');
        Route::get('allote-plotes/{id}','alloteePlotes');
        Route::get('plot-payment/{id}','plotePayments')->name('payment.read');
        Route::get('allote/edit/{id}','edit')->name('allote.write');
    });
    Route::controller(AccountController::class)
    ->group(function(){
        Route::get('account-heads','accountHead')->name('account-head.read');
        Route::get('cashbook','cashbook')->name('cashbook.read');
        Route::get('add-payment','payment')->name('payment.read');
        Route::post('get-account-heads','getAccountHeads');
        Route::get('expense','expenses')->name('expense.show');
        Route::get('payments','payments')->name('payments.show');
    });
    Route::get('/logs', [LogController::class,'index'])->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::controller(BankController::class)
        ->prefix('banks')
        ->group(function(){
            Route::get('list','index')->name('bank.index');
            Route::get('create','create');
    });
});

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
Route::get('{any}/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
require __DIR__.'/auth.php';
