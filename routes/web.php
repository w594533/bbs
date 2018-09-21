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
 //接口文档地址
Route::get('/swagger/doc', 'SwaggerController@doc')->name('swagger.doc');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/edit_avatar', 'UserController@edit_avatar')->name('users.edit_avatar');
    Route::put('/users/update_avatar', 'UserController@update_avatar')->name('users.update_avatar');
    Route::get('/users/edit_password', 'UserController@edit_password')->name('users.edit_password');
    Route::put('/users/update_password', 'UserController@update_password')->name('users.update_password');

    Route::resource('users', 'UserController', ['only' => ['index', 'show', 'edit', 'update']]);
});
