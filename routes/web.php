<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => ['auth']
], function () {
    Route::resource('produk', App\Http\Controllers\ProdukController::class);
    Route::resource('customer', App\Http\Controllers\CustomerController::class);
    Route::resource('penjualan', App\Http\Controllers\PenjualanController::class);

    Route::post(
        'penjualan/import',
        [App\Http\Controllers\PenjualanController::class, 'import']
    )->name('penjualan.import');

    Route::post(
        'drp/proses',
        [App\Http\Controllers\DRPController::class, 'proses']
    )->name('drp.proses');

    Route::get(
        'drp',
        [App\Http\Controllers\DRPController::class, 'index']
    )->name('drp.index');

    Route::get(
        'trend-moment',
        [App\Http\Controllers\TrendMomentController::class, 'index']
    )->name('trendmoment.index');

    Route::post(
        'trend-moment/proses',
        [App\Http\Controllers\TrendMomentController::class, 'proses']
    )->name('trendmoment.proses');

    Route::get(
        'mape',
        [App\Http\Controllers\MAPEController::class, 'index']
    )->name('mape.index');

    Route::post(
        'mape/proses',
        [App\Http\Controllers\MAPEController::class, 'proses']
    )->name('mape.proses');

    Route::get(
        'dashboard',
        [App\Http\Controllers\DashboardController::class, 'index']
    )->name('dashboard.index');

    Route::get(
        'dashboard/data/chart',
        [App\Http\Controllers\DashboardController::class, 'penjualan_tahunan']
    );
});

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});
