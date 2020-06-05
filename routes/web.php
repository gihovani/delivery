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

Route::get('/profile', 'Auth\ProfileController@show')->name('profile.show');
Route::post('/profile', 'Auth\ProfileController@update');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users/autocomplete','UserController@autocomplete')->name('users.autocomplete');
Route::resource('users','UserController')->middleware('auth');
Route::resource('users/{user}/addresses','AddressController')->middleware('auth');
Route::resource('categories','CategoryController')->middleware('auth');
Route::resource('variations','VariationController')->middleware('auth');
Route::resource('items','ItemController')->middleware('auth');
Route::resource('products','ProductController')->middleware('auth');
Route::get('config/{config}', 'ConfigController@edit')->name('configs.edit')->middleware('auth');
Route::put('config/{config}', 'ConfigController@update')->name('configs.update')->middleware('auth');
Route::get('orders','OrderController@index')->name('orders.index')->middleware('auth');
Route::get('orders/create','OrderController@create')->name('orders.create')->middleware('auth');
Route::post('orders','OrderController@store')->name('orders.store')->middleware('auth');
Route::get('orders/{order}/processing','OrderController@processing')->name('orders.processing')->middleware('auth');
Route::get('orders/{order}/delivery','OrderController@delivery')->name('orders.delivery')->middleware('auth');
Route::get('orders/{order}/complete','OrderController@complete')->name('orders.complete')->middleware('auth');
Route::get('orders/{order}/canceled','OrderController@canceled')->name('orders.canceled')->middleware('auth');
