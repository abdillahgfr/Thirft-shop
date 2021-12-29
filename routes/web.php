<?php

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

Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/about', 'AboutController@index')->name('about');

Route::get('/about/kontak', 'AboutController@kontak')->name('kontak');
Route::get('/about/alur', 'AboutController@alur')->name('alur');
Route::get('/about/fitur', 'AboutController@fitur')->name('fitur');

Route::get('/about/pesan', 'AboutController@pesan')->name('pesan');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/details/{id}', 'DetailController@index')->name('details');
Route::post('/details/{id}', 'DetailController@add')->name('detail-add');

Route::get('/cart', 'CartController@index')->name('cart');
Route::delete('/cart/{id}', 'CartController@delete')->name('cart-delete');
Route::get('/success', 'CartController@success')->name('success');

Route::post('/checkout', 'CheckoutController@process')->name('checkout');
Route::post('/checkout/callback', 'CheckoutController@callback')->name('midtrans-callback');
Route::get('/checkout/success', 'CheckoutController@success')->name('midtrans-success');
Route::get('/checkout/unfinish', 'CheckoutController@unfinish')->name('midtrans-unfinish');
Route::get('/checkout/error', 'CheckoutController@error')->name('midtrans-error');

Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');

Route::get('/dashboard/products/create', 'DashboardProductController@create')->name('dashboard-product-create');

Route::get('/dashboard/transactions', 'DashboardTransactionController@index')->name('dashboard-transaction');

Route::get('/dashboard/settings', 'DashboardSettingController@store')->name('dashboard-settings-store');
Route::get('/dashboard/account', 'DashboardSettingController@account')->name('dashboard-settings-account');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/cart', 'CartController@index')->name('cart');
    Route::delete('/cart/{id}', 'CartController@delete')->name('cart-delete');

    Route::get('/comment', 'DashboardCommentController@index')->name('comment');
    Route::get('{id}/detail', 'DetailController@reply')->name('comments-reply');

    Route::post('/checkout', 'CheckoutController@process')->name('checkout');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard/products', 'DashboardProductController@index')->name('dashboard-product');
    Route::get('/dashboard/products/create', 'DashboardProductController@create')->name('dashboard-product-create');
    Route::post('/dashboard/products', 'DashboardProductController@store')->name('dashboard-product-store');
    Route::get('/dashboard/products/{id}', 'DashboardProductController@details')->name('dashboard-product-details');
    Route::post('/dashboard/products/{id}', 'DashboardProductController@update')->name('dashboard-product-update');
    Route::delete('/dashboard/products/{id}', 'DashboardProductController@delete')->name('dashboard-product-delete');

    Route::post('/dashboard/products/gallery/upload', 'DashboardProductController@uploadGallery')->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', 'DashboardProductController@deleteGallery')->name('dashboard-product-gallery-delete');


    Route::get('/dashboard/transactions', 'DashboardTransactionController@index')->name('dashboard-transaction');
    Route::get('/dashboard/transactions/sell/{id}', 'DashboardTransactionController@details')->name('dashboard-transaction-details');
    Route::get('/dashboard/transactions/buy/{id}', 'DashboardTransactionController@detail')->name('dashboard-transaction-buy');
    Route::post('/dashboard/transactions/buy/{id}/review', 'DashboardTransactionController@review')->name('dashboard-transaction-buy-review');
    Route::post('/dashboard/transactions/{id}', 'DashboardTransactionController@update')->name('dashboard-transaction-update');


    Route::get('/dashboard/settings', 'DashboardSettingController@store')->name('dashboard-settings-store');
    Route::get('/dashboard/account', 'DashboardSettingController@account')->name('dashboard-settings-account');
    Route::get('/dashboard/profile', 'DashboardSettingController@profile')->name('dashboard-settings-profile');
    Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')->name('dashboard-settings-redirect');
    Route::post('/dashboard/settings/{redirect}', 'DashboardSettingController@update_store')->name('dashboard-settings-store-redirect');
    Route::post('/dashboard/profile/{redirect}', 'DashboardSettingController@update_profile')->name('dashboard-settings-profile-redirect');

    Route::get('posts', 'DetailController@posts')->name('posts');
    Route::post('posts', 'DetailController@postPost')->name('posts.post');
    Route::get('posts/{id}', 'DetailController@show')->name('posts.show');

    Route::get('review', 'DetailController@review')->name('add-review');

    Route::get('cari', 'CategoryController@cari')->name('cari');

    Route::get('/dashboard/comment', 'DashboardCommentController@index')->name('dashboard-comment');
});

//->middleware('auth','admin')

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('admin-dashboard');
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('product', 'ProductController');
        Route::resource('product-gallery', 'ProductGalleryController');
        Route::resource('transaction', 'TransactionController');
    });

Auth::routes(['verify' => true]);
