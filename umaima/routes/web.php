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
use App\Http\Controllers\BulkController;
use App\Http\Controllers\TransferController;


Route::get('/import', [BulkController::class, 'showImportForm'])->name('import.show');
Route::post('/import', [BulkController::class, 'import'])->name('import.upload');
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
// Route::post('/sign-in', [UsersController::class, 'login']);
Route::middleware('web')->group(function () {
    Route::post('/sign-in', [UsersController::class, 'login']);
    // other web routes
 });
Route::get("/clearData",function(){
    \Artisan::call('cache:clear');
     \Artisan::call('route:clear');
     \Artisan::call('config:cache');
     \Artisan::call('view:clear');

       return "Route cache cleared successfully!"; 
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('allote.index');
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
            Route::get("edit-scheme/{id}",'editScheme')->name('scheme.write');
            Route::get("edit/plot/{id}",'editPlot');
    });
    Route::controller(AlloteController::class)
    ->group(function(){
        Route::get('allote-listing','index')->name('allote.index');
        Route::get('create-allote','alloteCreate');
        Route::POST('edit-allote','editStore')->name('allote.edit');
        Route::get('allote-plotes/{id}','alloteePlotes');
        Route::get('plot-payment/{id}','plotePayments')->name('payment.read');
        Route::get('allote/edit/{id}','edit')->name('allote.write');
        Route::get('allote/inactive','inactive');
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
            Route::get("account-ledger/{id}",'detail');
           
    });
});









Route::middleware(['auth']) ->prefix('api')->group(function () {
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
    Route::post('/update-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.write');
    Route::post('/schemes', [SchemeController::class, 'listing'])->name('scheme.read');
    Route::post('/create-scheme-plot', [PlotController::class, 'store'])->name('plot.create');
    Route::post('/edit-scheme-plot', [PlotController::class, 'updateplot'])->name('plot.create');
    Route::post('/allote/plots/{id}',[PlotController::Class,'alloteePlotes'])->name('allotment.read');
    Route::post('/plots', [PlotController::class, 'listing'])->name('plot.read');
    Route::post('/scheme-plots/{id}', [PlotController::class, 'schemePlots'])->name('plot.read');
    Route::post('/alloted-scheme-plots/{id}', [PlotController::class, 'schemeAllotedPlots'])->name('plot.read');
    Route::post("create-allote",[AlloteController::class,'store'])->name('allote.create');
    Route::get("allote-list",[AlloteController::class,'listing'])->name('allote.read');
    Route::post("allote/plot/payments/{id}",[AlloteController::class,'plotPaymet'])->name('payment.read');
    Route::post('/plot-allotment', [PlotController::class, 'listing'])->name('allotment.create');
    Route::post('/confirm-schedule', [PlotController::class, 'confirmSchedule'])->name('schedule.create');
    Route::post('get-plots',[PlotController::class, 'getPlotsByAllote'])->name('plot.read');
    Route::post("getAllotees",[AlloteController::class,'geAll'])->name('allote.read');
    Route::post("getInActiveAllotees",[AlloteController::class,'getInActiveAllotees'])->name('allote.read');
    //accounts
    Route::controller(BankController::class)
        ->prefix('banks')
        ->group(function(){
            Route::post('listing','listing')->name('bank.read');
            Route::post('store','store')->name('bank.create');
            Route::post('delete','destroy')->name('bank.delete');
            Route::POST("account-ledger-list/{id}",'ledger')->name('bank.write');
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

    Route::controller(TransferController::class)
    ->group(function(){
        Route::get('plot/transfer','plotTransfer')->name('transfer.read');
       
    });
});
Route::middleware('auth')->prefix('api')->group(function(){
    Route::controller(TransferController::class)
    ->group(function(){
        Route::get('transerList','transerList')->name('transfer.read');
    });
    Route::post("getAllotiesNames",[AlloteController::class,'getAllotiesNames']);
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
