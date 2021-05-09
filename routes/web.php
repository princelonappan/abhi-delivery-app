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
    Route::post('admin-category-status', 'Admin\CategoryController@updateStatus')->name('admin.category.status');

    Route::resource('distributor', 'Admin\DistributorController', ['names' => 'admin.distributor']);
    Route::post('admin-distributor-status', 'Admin\DistributorController@updateStatus')->name('admin.distributor.status');
    // Route::resource('distributor.branch', 'Admin\BranchController');
    Route::resource('products', 'Admin\ProductController', ['names' => 'admin.products']);
    Route::post('admin-products-status', 'Admin\ProductController@updateStatus')->name('admin.products.status');
    Route::resource('products.image', 'Admin\ProductImageController', ['names' => 'admin.products.image']);
    Route::resource('distributor.branch', 'Admin\BranchController', ['names' => 'admin.distributor.branch']);
    Route::post('admin-branch-status', 'Admin\BranchController@updateStatus')->name('admin.branch.status');

    Route::resource('godown', 'Admin\GodownController', ['names' => 'admin.godown']);
    Route::get('palet-inventory/download-sample-csv', 'Admin\PaletInventoryController@download')->name('admin.palet-inventory.download-sample-csv');
    Route::resource('palet-inventory', 'Admin\PaletInventoryController', ['names' => 'admin.palet-inventory']);
    Route::resource('order', 'Admin\OrderController', ['names' => 'admin.order']);

    Route::resource('subscription', 'Admin\SubscriptionController', ['names' => 'admin.subscription']);
    Route::resource('vat', 'Admin\VatController', ['names' => 'admin.vat']);
    Route::resource('delivery-charge', 'Admin\DeliveryController', ['names' => 'admin.delivery_charge']);
    Route::resource('payment-mode', 'Admin\PaymentModeController', ['names' => 'admin.payment_mode']);

    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
 });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('payments', 'PaymentController@index');
Route::get('payments-response', 'PaymentController@store');
Route::get('payments-status', 'PaymentController@status');
Route::get('payments-cancel', 'PaymentController@update');



