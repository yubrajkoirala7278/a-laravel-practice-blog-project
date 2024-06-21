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

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
    Route::get('/blogs', 'BlogsController@index')->name('admin.blog');
    Route::get('/blog/create','BlogsController@create')->name('admin.blogs.create');
    Route::post('/blogs/store','BlogsController@store')->name('admin.blogs.store');
    Route::get('/blog/{slug}/edit','BlogsController@edit')->name('admin.blogs.edit');
    Route::get('/blog/{slug}','BlogsController@show')->name('admin.blogs.show');
    Route::delete('/blog/destroy/{blog}','BlogsController@destroy')->name('admin.blogs.destroy');
    Route::put('/blog/update/{blog}','BlogsController@update')->name('admin.blogs.update');
    Route::get('/home', 'HomeController@index')->name('admin.home');
});
