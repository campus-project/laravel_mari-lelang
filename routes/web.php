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

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/toc', 'WelcomeController@toc')->name('toc');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('select/province', 'ProvincesController@select')->name('province.select');
    Route::get('select/city', 'CitiesController@select')->name('city.select');
    Route::get('select/product-type', 'ProductTypesController@select')->name('product-type.select');

        Route::get('datatable/auction-product', 'AuctionProductsController@datatable')->name('auction-product.datatable');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('profile', 'ProfilesController')->except(['create', 'edit', 'destroy']);

    Route::resource('room', 'RoomsController')->only(['index']);
    Route::resource('auction-product', 'AuctionProductsController')->except(['create', 'edit']);

    Route::middleware(['admin'])->group(function () {
        Route::get('datatable/province', 'ProvincesController@datatable')->name('province.datatable');
        Route::get('datatable/city', 'CitiesController@datatable')->name('city.datatable');
        Route::get('datatable/product-type', 'ProductTypesController@datatable')->name('product-type.datatable');

        Route::resource('province', 'ProvincesController')->except(['create', 'edit']);
        Route::resource('city', 'CitiesController')->except(['create', 'edit']);
        Route::resource('product-type', 'ProductTypesController')->except(['create', 'edit']);
    });
});
