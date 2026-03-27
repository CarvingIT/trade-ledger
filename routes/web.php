<?php

use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['prefix' => '/admin'], function () {
    Route::group(['middleware'=>'admin'], function(){
        //Users
        Route::get('/users','\App\Http\Controllers\UserController@index')->name('users');
        Route::get('/user-form/{user_id}','\App\Http\Controllers\UserController@addEditUser');
        Route::post('/saveuser','\App\Http\Controllers\UserController@save');
        Route::post('/user/delete','\App\Http\Controllers\UserController@deleteUser');
        Route::get('/user/{user_id}','\App\Http\Controllers\UserController@viewUser');

        //Entities
        Route::get('/entities','\App\Http\Controllers\EntityController@index')->name('entities');
        Route::get('/entity-form/{entity_id}','\App\Http\Controllers\EntityController@addEditEntity');
        Route::post('/saveentity','\App\Http\Controllers\EntityController@save');
        Route::post('/entity/delete','\App\Http\Controllers\EntityController@deleteEntity');
        Route::get('/entity/{entity_id}','\App\Http\Controllers\EntityController@viewEntity');
    });
});


require __DIR__.'/auth.php';
