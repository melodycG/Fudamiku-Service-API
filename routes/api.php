<?php

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

/// ROUTE FOR AUTHENTICATION
Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});

Route::middleware(['auth:api'])->group(function () {

    /// ROUTE FOR USER
    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UserController@show');
        Route::put('/{id}', 'UserController@update');
    });

    /// ROUTE FOR FOOD
    Route::prefix('foods')->group(function () {
        Route::get('/', 'FoodController@index');
        Route::get('/{id}', 'FoodController@show');
        Route::post('/', 'FoodController@store');
        Route::put('/{id}', 'FoodController@update');
        Route::delete('/{id}', 'FoodController@destroy');
    });

    /// ROUTE FOR FOOD INGREDIENT
    Route::prefix('foods/ingredients')->group(function () {
        Route::get('/{id}', 'FoodIngredientController@show');
        Route::put('/{id}', 'FoodIngredientController@update');
        Route::delete('/{id}', 'FoodIngredientController@destroy');
    });

    /// ROUTE FOR ORDER
    Route::prefix('orders')->group(function () {
        Route::get('/{userID}', 'OrderController@show');
        Route::post('/', 'OrderController@store');
        Route::put('/{id}', 'OrderController@updateStatus');
    });

    /// ROUTE FOR TRANSACTION
    Route::prefix('transactions')->group(function () {
        Route::get('/{orderID}', 'TransactionController@show');
    });

    /// ROUTE FOR MIDTRANS
    Route::prefix('midtrans')->group(function () {
        Route::get('/token', 'MidtransController@getCardToken');
        Route::get('/status/{orderID}', 'MidtransController@getStatus');
        Route::post('/credit', 'MidtransController@chargeCreditCard');
        Route::post('/gopay', 'MidtransController@chargeGopay');
        Route::post('/cancel/{orderID}', 'MidtransController@cancelTransaction');
    });
    
});
