<?php

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
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'AboutController@index')->name('about');
Route::post('/cari','GlosariumController@search')->name('cari');
Route::post('/glosarium/upload','GlosariumController@upload')->name('glosarium.upload');
Route::resource('glosarium','GlosariumController');
