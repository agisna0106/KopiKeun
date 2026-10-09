<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\RawMaterialStockRecordController;
use App\Http\Controllers\IncomingGoodController;
use App\Http\Controllers\OperationalExpenseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\RemainingProductController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\OperationalItemController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SalesAnalyticsController;
use App\Http\Controllers\BaseDrinkController;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/logout-now', function () {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout.now');
});

Route::middleware(['auth', 'role:Owner,Staff Operasional'])
    ->group(function () {
        Route::resource('products', ProductController::class)
            ->except(['show']);

        Route::resource('carts', CartController::class)
            ->except(['show', 'destroy']);

        Route::resource('regions', RegionController::class)
            ->except(['show', 'destroy']);

        Route::resource('base-drinks', BaseDrinkController::class)
            ->except(['show']);

        Route::resource('operational-items',OperationalItemController::class)
            ->except(['show', 'destroy']);

        Route::resource('raw-materials', RawMaterialController::class)
            ->except(['show']);

        Route::resource('sales', SaleController::class);

        Route::resource('assignments', AssignmentController::class)
            ->except(['show']);

        Route::get('/analitik-penjualan',[SalesAnalyticsController::class, 'index'])
            ->name('sales-analytics.index');
    });

Route::middleware(['auth', 'role:Owner'])
    ->group(function () {
        Route::resource('employees', EmployeeController::class)
            ->except(['show']);

        Route::get(
            '/financial-reports',
            [FinancialReportController::class, 'index']
        )->name('financial-reports.index');
});

Route::middleware(['auth', 'role:Staff Operasional'])
    ->group(function () {

    Route::resource('distributions', DistributionController::class);

    Route::resource('incoming-goods',IncomingGoodController::class
        )->except(['show']);

    Route::resource('raw-material-stock-records',RawMaterialStockRecordController::class
        )->except(['show']);

    Route::resource('operational-expenses',OperationalExpenseController::class
            )->except(['show']);
});


Route::get('/owner-test', function () {
    return 'Halaman khusus Owner';
})->middleware(['auth', 'role:Owner']);

Route::get('/staff-operasional-test', function () {
    return 'Halaman khusus Staff Operasional';
})->middleware(['auth', 'role:Staff Operasional']);

Route::get('/karyawan-test', function () {
    return 'Halaman khusus Karyawan';
})->middleware(['auth', 'role:Karyawan']);

require __DIR__.'/auth.php';
