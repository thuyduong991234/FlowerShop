<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::namespace('API')->group(function () {
    //Route::middleware(['check.token'])->group(function () {
    //
    Route::apiResource('flowers', 'FlowerController');
    Route::get('flowers-export', 'FlowerController@export')->name('flowers.export');
    Route::post('flowers-import', 'FlowerController@import')->name('flowers.import');
    Route::get('flowers-statistic', 'FlowerController@statistic')->name('flowers.statistic');

    Route::apiResource('catalogs', 'CatalogController');
    Route::apiResource('transactions', 'TransactionController');
    //});

    //Route::middleware(['check.token','check.role:api'])->group(function () {
    //
    Route::apiResource('customers', 'CustomerController');
    Route::get('customers-statistic', 'CustomerController@statistic')->name('customers.statistic');
    Route::post('customers-import', 'CustomerController@import')->name('customers.import');
    Route::get('customers-export', 'CustomerController@export')->name('customers.export');
    //});

});


Route::get('get-catalogs', 'API\CatalogController@getAll')->name('catalogs.getall');

Route::post('admin/login', 'Admin\LoginController@login')->name('admin.login');
Route::post('admin/logout', 'Admin\LoginController@logout')->name('admin.logout');
Route::post('customer/login', 'Customer\LoginController@login')->name('customer.login');
Route::post('customer/logout', 'Customer\LoginController@logout')->name('customer.logout');
