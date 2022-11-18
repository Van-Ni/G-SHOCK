<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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


Route::get('test', function(){
    return view('product.detail');
});



Route::get('/', 'HomeController@index')->name('home');
//module page
Route::get("/{page}.html", "PageController@detail")->name('page');
//module post
Route::get("/bai-viet", "PostController@list")->name('post');
Route::get("/bai-viet/{post_slug}.html", "PostController@detail");
//module product
Route::get("san-pham", "ProductController@list")->name('product');
Route::get("danh-muc/{parent_cat}", "ProductController@cat")->name('cat');
Route::get("danh-muc/{parent_cat}/{child_cat}", "ProductController@childCat")->name('childCat');
Route::get("san-pham/{product}.{id}.html", "ProductController@detailProduct")->name('detailProduct');
Route::post("liveSearch", "ProductController@liveSearch")->name('liveSearch');
// comment product
Route::post("ajaxLogin", "ProductController@ajaxLogin")->name('ajaxLogin');
Route::post("ajaxComment", "ProductController@ajaxComment")->name('ajaxComment');

//module cart
Route::post('/cart/add/{id}', "CartController@addCart")->name('addCart');
Route::get('/gio-hang', "CartController@list")->name('listCart');
Route::post("/cart/update", "CartController@updateCart")->name('updateCart');
// Route::get('/cart/delete/{id}',"CartController@deleteCart")->name('deleteCart');
Route::post('/cart/delete', "CartController@deleteCart")->name('deleteCart');
Route::get('/cart/destroy', "CartController@destroyCart")->name('destroyCart');
Route::post("checkCoupon", "CartController@coupon")->name('checkCoupon');
// module checkout
Route::get('/thanh-toan', "CheckoutController@checkout")->name('checkout');
Route::post('/storeCheckout', "CheckoutController@storeCheckout")->name('storeCheckout');
Route::post('/getDistrict', "CheckoutController@getDistrict")->name('getDistrict');
Route::post('/getWard', "CheckoutController@getWard")->name('getWard');
Route::get('/dat-hang-thanh-cong/{orderCode}', "CheckoutController@successOrder")->name('successOrder');

// http client
Route::get("/getAllPosts", "httpClientController@list");
Route::get("/detailPost/{id}", "httpClientController@detail");

// ============
// login client
// ============
Route::get('/login/client', 'LoginController@showClientLoginForm');
Route::get('/logout/client', 'LoginController@logout');
Route::get('/register/client', 'RegisterController@showClientRegisterForm');
Route::post('/login/client', 'LoginController@clientLogin');
Route::post('/register/client', 'RegisterController@createClient');
// Route::group(['middleware' => 'auth:admin'], function () {
//     Auth::routes();
//     Route::view('/admin', 'admin');
// });
Route::resource('demo',"demoController");