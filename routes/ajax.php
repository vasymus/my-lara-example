<?php

/*
|--------------------------------------------------------------------------
| Web Routes for ajax requests
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * !!!
 * Prefix "ajax"
 * Name "ajax."
 * !!!
 * */

use App\Constants;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth:" . implode(',', [Constants::AUTH_GUARD_WEB, Constants::AUTH_GUARD_ADMIN])])->group(function() {
    Route::post("products/aside", [\App\Http\Controllers\Web\Ajax\AsideProductsController::class, "store"])->name("products.aside.store");
    Route::delete("products/aside", [\App\Http\Controllers\Web\Ajax\AsideProductsController::class, "delete"])->name("products.aside.delete");

    Route::get("products/cart", [\App\Http\Controllers\Web\Ajax\CartProductsController::class, "index"])->name("products.cart.index");
    Route::post("products/cart", [\App\Http\Controllers\Web\Ajax\CartProductsController::class, "store"])->name("products.cart.store");
    Route::put("products/cart", [\App\Http\Controllers\Web\Ajax\CartProductsController::class, "update"])->name("products.cart.update");
    Route::delete("products/cart", [\App\Http\Controllers\Web\Ajax\CartProductsController::class, "delete"])->name("products.cart.delete");

    Route::post("orders/{id}", [\App\Http\Controllers\Web\Ajax\OrderController::class, "update"])->name("orders.update");
});
