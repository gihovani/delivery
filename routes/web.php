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

Route::get('/', function () {
    return view('welcome');
})->name('guest');

Auth::routes();


Route::get('/distance/{address}', 'AddressController@distance')->name('address.distance');
Route::get('/profile', 'Auth\ProfileController@show')->name('profile.show');
Route::post('/profile', 'Auth\ProfileController@update');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'role:' . \App\User::ROLE_ADMIN], function () {
    Route::get('/reports', 'ReportController@index')->name('reports.index');
    Route::post('/reports/orders', 'ReportController@orders')->name('reports.orders');
    Route::post('/reports/transactions', 'ReportController@transactions')->name('reports.transactions');
    Route::get('/users/autocomplete', 'UserController@autocomplete')->name('users.autocomplete');
    Route::resource('users', 'UserController');
    Route::resource('users/{user}/addresses', 'AddressController');
    Route::resource('categories', 'CategoryController');
    Route::resource('variations', 'VariationController');
    Route::resource('items', 'ItemController');
    Route::resource('products', 'ProductController');
    Route::get('products/{product}/details', 'ProductController@details')->name('products.details');
    Route::get('config/{config}', 'ConfigController@edit')->name('configs.edit');
    Route::put('config/{config}', 'ConfigController@update')->name('configs.update');
    Route::get('orders', 'OrderController@index')->name('orders.index');
    Route::get('orders/create', 'OrderController@create')->name('orders.create');
    Route::post('orders', 'OrderController@store')->name('orders.store');
    Route::get('orders/{order}/print', 'OrderController@print')->name('orders.print');
    Route::post('orders/{order}/processing', 'OrderController@processing')->name('orders.processing');
    Route::post('orders/{order}/delivery', 'OrderController@delivery')->name('orders.delivery');
    Route::post('orders/{order}/complete', 'OrderController@complete')->name('orders.complete');
    Route::post('orders/{order}/canceled', 'OrderController@canceled')->name('orders.canceled');
});
