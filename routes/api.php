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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function() {
  /**
   * Account Routes
   */
  Route::group(['prefix' => 'account'], function () {
    Route::post('/deposit', 'App\Http\Controllers\Customer\BankAccountController@deposit');
    Route::post('/withdraw', 'App\Http\Controllers\Customer\BankAccountController@withdraw');
    Route::post('/transfer', 'App\Http\Controllers\Customer\BankAccountController@transfer');
    Route::get('/statement', 'App\Http\Controllers\Customer\BankAccountController@getStatement');
  });

  Route::get('/me', 'App\Http\Controllers\UserController@me');
});
