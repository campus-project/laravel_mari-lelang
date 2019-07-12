<?php

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

use Illuminate\Support\Facades\Hash;

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/toc', 'WelcomeController@toc')->name('toc');
Route::post('/contact', 'WelcomeController@contact')->name('contact');
Route::get('topup/approve/{token}', 'TopupsController@approve')->name('topup.approve');
Route::get('withdrawal/approve/{token}', 'WithdrawalsController@approve')->name('withdrawal.approve');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('datatable/province', 'ProvincesController@datatable')->name('province.datatable');
        Route::get('datatable/city', 'CitiesController@datatable')->name('city.datatable');
        Route::get('datatable/product-type', 'ProductTypesController@datatable')->name('product-type.datatable');

        Route::resource('province', 'ProvincesController')->except(['create', 'edit']);
        Route::resource('city', 'CitiesController')->except(['create', 'edit']);
        Route::resource('product-type', 'ProductTypesController')->except(['create', 'edit']);
    });

    Route::get('select/province', 'ProvincesController@select')->name('province.select');
    Route::get('select/city', 'CitiesController@select')->name('city.select');
    Route::get('select/product-type', 'ProductTypesController@select')->name('product-type.select');

    Route::get('datatable/auction-product', 'AuctionProductsController@datatable')->name('auction-product.datatable');
    Route::get('datatable/transaction', 'TransactionsController@datatable')->name('transaction.datatable');
    Route::get('datatable/product', 'ProductsController@datatable')->name('product.datatable');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('update-password', 'UsersController@updatePassword')->name('user.update-password');
    Route::resource('user', 'UsersController')->only(['show', 'update']);

    Route::resource('profile', 'ProfilesController')->only(['index', 'update', 'show']);
    Route::resource('topup', 'TopupsController')->only(['store']);
    Route::post('topup/verification', 'TopupsController@verification')->name('topup.verification');
    Route::resource('withdrawal', 'WithdrawalsController')->only(['store']);

    Route::resource('auction-product', 'AuctionProductsController')->except(['create', 'edit']);
    Route::resource('bid', 'BidsController')->only(['store']);
    Route::resource('product', 'ProductsController')->only('index');
    Route::get('/product/{id}', 'ProductsController@show')->name('product.show');
});
