<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('admin/login','Admin\LoginController@login')->name('adminLogin');
Route::post('admin/logout','Admin\LoginController@logout')->name('adminLogout');
Route::post('customer/login','Customer\LoginController@login')->name('customerLogin');
Route::post('customer/logout','Customer\LoginController@logout')->name('customerLogout');