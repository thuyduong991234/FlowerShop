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



Route::namespace('API')->group(function (){
    Route::middleware(['auth:api,customer'])->group(function () {
        //
        Route::apiResource('flowers','FlowerController');
        Route::apiResource('catalogs','CatalogController');
        Route::apiResource('transactions','TransactionController');
    });
    Route::group(['middleware' => 'auth:api'], function (){
        Route::apiResource('customers','CustomerController');
    });

});