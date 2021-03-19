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

Route::get('/', 'HostelController@index')->name('index');

Auth::routes();
Route::get('/approval', 'HomeController@approve')->name('approval');
Route::middleware(['approved'])->group(function () {
    Route::get('/home', 'HomeController@home')->name('home');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/users', 'UserController@getPendingUsers')->name('getPendingUsers');
    Route::get('/users/{user_id}/approve', 'UserController@approve')->name('approvePendingUser');
});

Route::get('/hostel/new', 'HostelController@newHostel')->name('newHostel');
Route::post('/hostel/insert', 'HostelController@insertHostel')->name('insertHostel');
Route::get('/hostel/list', 'HostelController@listHostel')->name('listHostel');
Route::get('/hostel/{id}', 'HostelController@viewHostel')->name('viewHostel');
Route::match(array('GET', 'POST'), '/hostel/update/{id}', 'HostelController@updateHostel')->name('updateHostel');
Route::match(array('GET', 'POST'), '/hostel/delete/{id}', 'HostelController@deleteHostel')->name('deleteHostel');
Route::match(array('GET', 'POST'), '/hostel/search', 'HostelController@findByAddress')->name('findByAddress');
Route::post('/hostel/requestBooking', 'HostelController@requestBooking')->name('requestBooking');
Route::get('/getBookingRequests', 'HostelController@getBookingRequests')->name('getBookingRequests');

