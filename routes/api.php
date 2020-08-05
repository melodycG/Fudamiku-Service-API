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

Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('user')->group(function() {
        Route::get('/{id}', 'UserController@show');
    });

    Route::prefix('foods')->group(function() {
        Route::get('/', 'FoodController@index');
        Route::get('/{id}', 'FoodController@show');
        Route::post('/', 'FoodController@store');
        Route::put('/{id}', 'FoodController@update');
        Route::delete('/{id}', 'FoodController@destroy');
    });

    Route::prefix('foods/ingredients')->group(function() {
        Route::post('/', 'FoodIngredientController@store');
        Route::put('/{id}', 'FoodIngredientController@update');
        Route::delete('/{id}', 'FoodIngredientController@destroy');
    });

    Route::prefix('orders')->group(function() {
        Route::get('/{userId}', 'OrderController@show');
        Route::post('/', 'OrderController@store');
        Route::put('/{id}', 'OrderController@updateStatus');
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/{orderId}', 'TransactionController@show');
        Route::post('/', 'TransactionController@store');
    });

});
