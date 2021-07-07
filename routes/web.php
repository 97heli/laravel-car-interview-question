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
Route::namespace('HeLiTest')->prefix('helitest')->group(function () {
    //route
    Route::prefix('test')->group(function () {
        Route::any('appointmentsList', 'TestController@appointmentsList');
        Route::any('saveAppointments', 'TestController@saveAppointments');
        Route::any('workshopsList', 'TestController@workshopsList');
    });
});