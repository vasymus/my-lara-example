<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Admin
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Constants;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ExportProductController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get("home", [HomeController::class, "index"])->name(Constants::ROUTE_ADMIN_HOME);
Route::get("media/{id}/{name?}", [HomeController::class, "media"])->name(Constants::ROUTE_ADMIN_MEDIA);

Route
    ::get(
        "products",
        [ProductsController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_INDEX)
;
Route
    ::get(
        "products/create",
        [ProductsController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_CREATE)
;
Route
    ::get(
        "products/{admin_product}/edit",
        [ProductsController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_EDIT)
;

Route
    ::get(
        "categories",
        [CategoriesController::class, 'index']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_INDEX)
;
Route
    ::get(
        "categories/create",
        [CategoriesController::class, 'create']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_CREATE)
;
Route
    ::get(
        "categories/{admin_category}/edit",
        [CategoriesController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_EDIT)
;

Route
    ::get(
        "brands",
        [BrandsController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_INDEX)
;
Route
    ::get(
        "brands/create",
        [BrandsController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_CREATE)
;
Route
    ::get(
        "brands/{admin_brand}/edit",
        [BrandsController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_EDIT)
;

Route
    ::get(
        "orders",
        [OrdersController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_INDEX)
;
Route
    ::get(
        "orders/create",
        [OrdersController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_CREATE)
;
Route
    ::get(
        "orders/{admin_order}/edit",
        [OrdersController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_EDIT)
;

Route::
    get(
        'export-products',
        [ExportProductController::class, 'index']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)
;
Route::
    get(
        'export-products/{id}',
        [ExportProductController::class, 'show']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW)
;
Route::
    post(
        'export-products',
        [ExportProductController::class, 'store']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_STORE)
;
Route::
    delete(
        'export-products/{id}',
        [ExportProductController::class, 'delete']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE)
;
