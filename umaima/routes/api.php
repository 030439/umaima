<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\AlloteController;
use App\Http\Controllers\AccountController;
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
    //Schemes and allotments
    Route::post('/create-scheme', [SchemeController::class, 'store'])->name('scheme.create');
    Route::post('/schemes', [SchemeController::class, 'listing'])->name('scheme.read');
    Route::post('/create-scheme-plot', [PlotController::class, 'store'])->name('plot.create');
    Route::post('/allote/plots/{id}',[PlotController::Class,'alloteePlotes'])->name('allotment.read');
    Route::post('/plots', [PlotController::class, 'listing'])->name('plot.read');
    Route::post('/scheme-plots/{id}', [PlotController::class, 'schemePlots'])->name('plot.read');
    Route::post("create-allote",[AlloteController::class,'store'])->name('allote.create');
    Route::get("allote-list",[AlloteController::class,'listing'])->name('allote.read');
    Route::post("allote/plot/payments/{id}",[AlloteController::class,'plotPaymet'])->name('payment.read');
    Route::post('/plot-allotment', [PlotController::class, 'listing'])->name('allotment.create');
    Route::post('/confirm-schedule', [PlotController::class, 'confirmSchedule'])->name('schedule.create');
    Route::post('get-plots',[PlotController::class, 'getPlotsByAllote'])->name('plot.read');
    Route::post("getAllotees",[AlloteController::class,'geAll'])->name('allote.read');
    //accounts
    Route::controller(BankController::class)
        ->prefix('banks')
        ->group(function(){
            Route::post('listing','listing')->name('bank.read');
            Route::post('store','store')->name('bank.create');
            Route::post('delete','destroy')->name('bank.delete');
    });
    Route::controller(AccountController::class)
    ->group(function(){
        Route::POST('apply/surcharge','applyCharge')->name('payment.create');
        Route::POST('fetch-accounts','fetchAccounts')->name('cash.create');
        Route::POST('cash/store','storePayment')->name('payment.create');
        Route::POST('account-heads','addAccountHead')->name('account-head.create');
        Route::POST('getPayments','getPayments')->name('payment.read');
        Route::POST('getExpenses','getExpenses')->name('payment.read');
        Route::POST('getPaymentsVoucher','getPaymentsVoucher')->name('payment.read');
    });
});
Route::middleware('auth:sanctum')->group(function(){
    Route::post("get-alloties",[AlloteController::class,'getAlloties']);
    Route::post('/get-scheme-details', [SchemeController::class, 'getSchemeDetails']);
    Route::post('/get-plots-by-scheme', [PlotController::class, 'getplotByScheme']);
    Route::post('get-installments',[PlotController::class,'getInstallments']);
    Route::post('/get-plots-detail', [PlotController::class, 'getplotDetails']);
    Route::post('/show-payment-schedule', [PlotController::class, 'paymentSchedule']);
    Route::post('/get-user', [UsersController::class, 'getUser'])->name('user.get');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

