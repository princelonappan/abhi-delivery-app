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

    Route::post('customer/generate-otp', 'CustomerController@generateOtp');

	//Customer API
	Route::post('customer/register', 'CustomerController@register');
	Route::post('customer/login', 'CustomerController@login');
	Route::get('customer', 'CustomerController@index');
    Route::get('customer/{id}', 'CustomerController@show');
    Route::post('customer/{id}', 'CustomerController@update');
    Route::post('customer-update-email', 'CustomerController@updateEmail');
    Route::post('customer-update-phone', 'CustomerController@updatePhone');

	//Distributor API
	Route::post('distributor/login', 'DistributorController@store');

	//Category and Product API
	Route::get('category', 'CategoryController@index');
	Route::get('product', 'ProductController@index');
	Route::get('product/{id}', 'ProductController@show');

	//Cart API
	Route::get('cart', 'CartController@index');
	Route::get('cart/{id}', 'CartController@show');
	Route::post('cart', 'CartController@store');
	Route::put('cart/{id}', 'CartController@update');

    //Cart API
	Route::get('cart-v2', 'CartV2Controller@index');
	Route::get('cart-v2/{id}', 'CartV2Controller@show');
	Route::post('cart-v2', 'CartV2Controller@store');
	Route::put('cart-v2/{id}', 'CartV2Controller@update');

	//Address API
	Route::get('address/{id}', 'AddressController@show');
	Route::get('address', 'AddressController@index');
	Route::post('address', 'AddressController@store');
	Route::put('address/{id}', 'AddressController@update');

	//Checkout API
	Route::post('order', 'OrderController@store');
	Route::get('order', 'OrderController@index');
	Route::get('order/{id}', 'OrderController@show');
	Route::post('order-cancel', 'OrderController@cancelOrder');

    Route::resource('favourites', 'FavouriteController');

    Route::get('home', 'HomePageController@index');

    //Distributor Cart API
	Route::get('distributor/cart', 'Distributor\DistributorCartController@index');
	Route::get('distributor/cart/{id}', 'Distributor\DistributorCartController@show');
	Route::post('distributor/cart', 'Distributor\DistributorCartController@store');
	Route::put('distributor/cart/{id}', 'Distributor\DistributorCartController@update');

    Route::post('distributor/order', 'Distributor\DistributorOrderController@store');
	Route::get('distributor/order', 'Distributor\DistributorOrderController@index');
	Route::get('distributor/order/{id}', 'Distributor\DistributorOrderController@show');
	Route::post('distributor/order-cancel', 'Distributor\DistributorOrderController@cancelOrder');


    Route::get('distributor/product', 'Distributor\DistributorProductController@index');
	Route::get('distributor/product/{id}', 'Distributor\DistributorProductController@show');

    //Category and Product API
	Route::get('distributor/category', 'Distributor\DistributorCategoryController@index');

    Route::get('distributor/branches', 'Distributor\DistributorAddressController@index');
    Route::get('distributor/delivery-types', 'Distributor\DistributorAddressController@orderTypes');

    // Route::resource('favourites', 'Distributor\PaletController@index');
	Route::get('distributor/palet', 'Distributor\PaletController@index');
    Route::get('distributor/palet/{id}', 'Distributor\PaletController@show');
	Route::post('distributor/palet', 'Distributor\PaletController@store');
	Route::put('distributor/palet/{id}', 'Distributor\PaletController@update');
    Route::post('distributor/palet-delete', 'Distributor\PaletController@destroy');
    Route::post('distributor/palet-complete', 'Distributor\PaletController@completePalet');
    Route::post('distributor/palet-lists', 'Distributor\PaletController@paletLists');



});
