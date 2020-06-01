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

Route::resource('users','UserController')->middleware('auth');
Route::resource('users/{user}/addresses','AddressController')->middleware('auth');
Route::resource('categories','CategoryController')->middleware('auth');
Route::resource('variations','VariationController')->middleware('auth');
Route::resource('product_items','ProductItemController')->middleware('auth');
Route::resource('products','ProductController')->middleware('auth');
