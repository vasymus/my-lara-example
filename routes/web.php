<?php

use App\Constants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('---test/{id?}/{hash?}', [\App\Http\Controllers\TestController::class, 'test'])->name('test');
Route::get('---test-email-order', [\App\Http\Controllers\TestController::class, 'testEmailOrder'])->middleware('auth');
Route::get('---test-email-order-markup', [\App\Http\Controllers\TestController::class, 'testEmailOrderMarkup'])->middleware('auth');
Route::get("---test-email-password-reset", [\App\Http\Controllers\TestController::class, "testResetPasswordMarkup"])->middleware('auth');

Route::middleware([Constants::MIDDLEWARE_AUTHENTICATE_ALL])->group(function() {

    /** @see \Laravel\Ui\AuthRouteMethods::auth() */
    Route
        ::get('login', [\App\Http\Controllers\Web\Auth\LoginController::class, "showLoginForm"])
        ->name('login')
    ;
    Route
        ::post('login', [\App\Http\Controllers\Web\Auth\LoginController::class, "login"])
    ;
    Route
        ::post("logout", [\App\Http\Controllers\Web\Auth\LoginController::class, "logout"])
        ->name("logout")
    ;

    Route::get('password/reset', [\App\Http\Controllers\Web\Auth\ForgotPasswordController::class, "showLinkRequestForm"])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Web\Auth\ForgotPasswordController::class, "sendResetLinkEmail"])->name('password.email');

    Route::get('password/reset/{token}', [\App\Http\Controllers\Web\Auth\ResetPasswordController::class, "showResetForm"])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Web\Auth\ResetPasswordController::class, "reset"])->name('password.update');

    Route
        ::get(
            "catalog/{category_slug}/{product_slug}.html",
            [\App\Http\Controllers\Web\ProductsController::class, "show"]
        )
        ->name("product.show.1")
    ;
    Route
        ::get(
            "catalog/{category_slug}/{subcategory1_slug}/{product_slug}.html",
            [\App\Http\Controllers\Web\ProductsController::class, "show"]
        )
        ->name("product.show.2")
    ;
    Route
        ::get(
            "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{product_slug}.html",
            [\App\Http\Controllers\Web\ProductsController::class, "show"]
        )
        ->name("product.show.3")
    ;
    Route
        ::get(
            "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{subcategory3_slug}/{product_slug}.html",
            [\App\Http\Controllers\Web\ProductsController::class, "show"]
        )
        ->name("product.show.4")
    ;

    Route
        ::get(
            "catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{subcategory3_slug?}",
            [\App\Http\Controllers\Web\ProductsController::class, "index"]
        )
        ->name("products.index")
    ;

    Route::get("brands", [\App\Http\Controllers\Web\BrandsController::class, "index"])->name("brands.index");
    Route::get("brands/{brand_slug}.html", [\App\Http\Controllers\Web\BrandsController::class, "show"])->name("brands.show");

    Route::get("photos", [\App\Http\Controllers\Web\GalleryItemsController::class, "index"])->name("gallery.items.index");
    Route::get("photos/{parentGalleryItemSlug}", [\App\Http\Controllers\Web\GalleryItemsController::class, "show"])->name("gallery.items.show");

    Route::get("articles/{article_slug}/{subarticle_slug?}", [\App\Http\Controllers\Web\ArticlesController::class, "show"])->name("articles.show");

    Route::get("faq", [\App\Http\Controllers\Web\FaqController::class, "index"])->name("faq.index");
    Route::get("faq/{faq_slug}", [\App\Http\Controllers\Web\FaqController::class, "show"])->name("faq.show");

    Route::get("ask", [\App\Http\Controllers\Web\HomeController::class, "ask"])->name("ask");

    Route::get("videos", [\App\Http\Controllers\Web\VideosController::class, "index"])->name("videos.index");

    Route::get("howto", [\App\Http\Controllers\Web\HomeController::class, "howto"])->name("howto");

    Route::get("delivery", [\App\Http\Controllers\Web\HomeController::class, "delivery"])->name("delivery");

    Route::get("return", [\App\Http\Controllers\Web\HomeController::class, "purchaseReturn"])->name("return");

    Route::get("contacts", [\App\Http\Controllers\Web\HomeController::class, "contacts"])->name("contacts");

    Route::get("viewed", [\App\Http\Controllers\Web\HomeController::class, "viewed"])->name("viewed");

    Route::get("aside", [\App\Http\Controllers\Web\HomeController::class, "aside"])->name("aside");

    Route::get('cart', [\App\Http\Controllers\Web\CartController::class, "show"])->name("cart.show");

    Route::get('cart-success/{order_id}', [\App\Http\Controllers\Web\CartController::class, "success"])->name("cart.success");

    Route::post("cart-checkout", \App\Http\Controllers\Web\CartCheckoutController::class)->name("cart.checkout");

    Route
        ::get("profile", [\App\Http\Controllers\Web\ProfileController::class, "show"])
        ->name("profile")
        //->middleware(\App\Constants::MIDDLEWARE_REDIRECT_IF_NOT_IDENTIFIED)
    ;

    Route::get("orders/{id}", [\App\Http\Controllers\Web\OrdersConstroller::class, "show"])->name("orders.show");

    Route::get("profile-identify/{id}/{email}/{hash}", [\App\Http\Controllers\Web\ProfileController::class, "identify"])->name("profile.identify")->middleware(["signed"]);

    // TODO think of route if move to aws
    Route::get('media/{id}/{name?}', [\App\Http\Controllers\Web\HomeController::class, "media"])->name("media");

    Route::get("/{service_slug}", [\App\Http\Controllers\Web\ServicesController::class, "show"])->name("services.show");

    Route::get("/", [\App\Http\Controllers\Web\HomeController::class, "index"])->name("home");

});

