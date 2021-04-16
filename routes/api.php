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

	/**
	 * Customer APIs
	 */
	Route::post('customer/register', 'CustomerController@register');
	Route::post('customer/login', 'CustomerController@login');
	Route::get('category', 'CategoryController@index');
	Route::get('product', 'ProductController@index');
	// Route::post('customer/verify', 'CustomerController@verify');
	// Route::post('customer/validate', 'CustomerController@valid');	
});
