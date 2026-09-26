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

Route::middleware(['auth', 'role:Owner,Admin'])
    ->group(function () {
        Route::resource('products', ProductController::class)
            ->except(['show']);

        Route::resource('raw-materials', RawMaterialController::class)
            ->except(['show']);

        Route::resource('incoming-goods',IncomingGoodController::class
        )->except(['show']);

        Route::resource('raw-material-stock-records',RawMaterialStockRecordController::class
        )->except(['show']);

        Route::resource('operational-expenses',OperationalExpenseController::class
        )->except(['show']);

        Route::resource('sales', SaleController::class);

        Route::resource('distributions', DistributionController::class);

        Route::resource('remaining-products',RemainingProductController::class);

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


Route::get('/owner-test', function () {
    return 'Halaman khusus Owner';
})->middleware(['auth', 'role:Owner']);

Route::get('/admin-test', function () {
    return 'Halaman khusus Admin';
})->middleware(['auth', 'role:Admin']);

Route::get('/karyawan-test', function () {
    return 'Halaman khusus Karyawan';
})->middleware(['auth', 'role:Karyawan']);

require __DIR__.'/auth.php';
