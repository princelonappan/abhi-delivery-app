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

Route::prefix('admin')->group(function() {
    Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');
    Route::resource('category', 'Admin\CategoryController', ['names' => 'admin.category']);
    Route::resource('distributor', 'Admin\DistributorController', ['names' => 'admin.distributor']);
    // Route::resource('distributor.branch', 'Admin\BranchController');
    Route::resource('products', 'Admin\ProductController', ['names' => 'admin.products']);
    Route::resource('products.image', 'Admin\ProductImageController', ['names' => 'admin.products.image']);
    Route::resource('distributor.branch', 'Admin\BranchController', ['names' => 'admin.distributor.branch']);
   }) ;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



