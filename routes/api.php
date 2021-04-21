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

Route::group(['prefix' => 'v1', 'middleware' => ['api.response.formatter']], function() {

	Route::post('customer/register', 'CustomerController@register');
	Route::post('customer/login', 'CustomerController@login');
	Route::get('customer', 'CustomerController@index');
	Route::get('category', 'CategoryController@index');
	Route::get('product', 'ProductController@index');
	Route::get('cart', 'CartController@index');
	Route::get('cart/{id}', 'CartController@show');
	Route::post('cart', 'CartController@store');
	Route::put('cart/{id}', 'CartController@update');
	Route::get('address/{id}', 'AddressController@show');
	Route::get('address', 'AddressController@index');
	Route::post('address', 'AddressController@store');
	Route::put('address/{id}', 'AddressController@update');
});
