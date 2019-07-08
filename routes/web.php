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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/toc', function () {
    return view('toc');
})->name('toc');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::middleware(['admin'])->group(function () {
        Route::get('datatable/province', 'ProvincesController@datatable')->name('province.datatable');
        Route::get('datatable/city', 'CitiesController@datatable')->name('city.datatable');
        Route::get('datatable/product-type', 'ProductTypesController@datatable')->name('product-type.datatable');

        Route::resource('province', 'ProvincesController')->except(['create', 'edit']);
        Route::resource('city', 'CitiesController')->except(['create', 'edit']);
        Route::resource('product-type', 'ProductTypesController')->except(['create', 'edit']);
    });
});
