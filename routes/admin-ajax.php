<?php

/*
|--------------------------------------------------------------------------
| Web Routes for admin ajax requests
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * !!!
 * Prefix "admin-ajax"
 * Name "admin-ajax."
 * !!!
 * */

use Illuminate\Support\Facades\Route;

Route::put('profiles/{admin}', [\App\Http\Controllers\Admin\Ajax\ProfileController::class, 'update'])->name('profile.update');
Route::post('show-order-busy', \App\Http\Controllers\Admin\Ajax\ShowOrderBusyController::class)->name('show-order-busy');
Route::post('ping-order-busy/{id}', \App\Http\Controllers\Admin\Ajax\PingOrderBusyController::class)->name('ping-order-busy');
