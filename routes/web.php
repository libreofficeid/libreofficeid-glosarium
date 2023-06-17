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
});

Auth::routes([
    'register' => env('ALLOW_REGISTRATION', false),
    'reset'    => env('ALLOW_RESET_PASS', false),
]);

Route::get('/home', '\App\Http\Controllers\HomeController@index')->name('home');
Route::get('/about', '\App\Http\Controllers\AboutController@index')->name('about');
Route::post('/cari','\App\Http\Controllers\GlosariumController@search')->name('cari');
Route::post('/glosarium/upload','\App\Http\Controllers\GlosariumController@upload')->name('glosarium.upload');
Route::resource('glosarium','\App\Http\Controllers\GlosariumController');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
