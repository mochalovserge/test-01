<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', 'ProductController@products');
Route::get('/product/{product_id}', 'ProductController@product')->where('product_id', '[0-9]+');

Route::delete('/cart/{product_id}', 'CartController@delCart')->where('product_id', '[0-9]+');
Route::post('/cart', 'CartController@addCart');
Route::get('/cart', 'CartController@getCart');
