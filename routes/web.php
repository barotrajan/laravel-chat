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

Route::middleware('auth')->group(function () {
    // Chat Routes
    Route::get('/', 'ChatController@index')->name('index');
    Route::get('/chats/{id}', 'ChatController@show')->name('show');
    Route::post('/create-chat', 'ChatController@createChat')->name('create-chat');
    Route::post('/send-message', 'ChatController@sendMessage')->name('send-message');
    Route::post('/received-message', 'ChatController@receiveMessage')->name('receive-message');
    Route::post('/delete-message', 'ChatController@deleteMessage')->name('delete-message');
    Route::post('/get-users', 'ChatController@getUsers')->name('get-users');



    Route::post('/logout', 'AuthController@logout')->name('logout');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login');
    Route::post('/login', 'AuthController@login')->name('login');
});
