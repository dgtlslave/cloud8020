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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/park', 'ParkController@index')->name('park');
Route::get('/park/create', 'ParkController@create_view');
Route::post('/savePark', 'ParkController@savePark');
Route::get('/getAllPark', 'ParkController@getAllPark');
Route::get('/park/{id}/edit', 'ParkController@edit_park');
