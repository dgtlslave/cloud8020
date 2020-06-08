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
Route::get('/edit_view/{park}', 'ParkController@edit_view');
Route::post('/save_edited_park', 'ParkController@save_edited_park');
Route::post('/delete_park', 'ParkController@delete_park');
Route::get('/vehicle/create', 'VehicleController@create_view');
Route::post('/saveVehicle', 'VehicleController@saveVehicle');
Route::get('/view_vehicle/{park}', 'ParkController@view_vehicle');
Route::get('/edit_view/{vehicle}', 'VehicleController@edit_view');
Route::post('/edit_vehicle', 'VehicleController@edit_vehicle');
Route::post('/delete_vehicle', 'VehicleController@delete_vehicle');
Route::get('/get_auth_user', 'VehicleController@get_auth_user');
