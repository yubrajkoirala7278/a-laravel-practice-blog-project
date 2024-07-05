<?php

use Illuminate\Support\Facades\Route;
use Modules\Blogs\Http\Controllers\admin\BlogsController;
use Modules\Blogs\Http\Controllers\admin\HomeController;
use Modules\Blogs\Http\Controllers\admin\RoleController;
use Modules\Blogs\Http\Controllers\admin\UserController;

Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

// ======blogs============
Route::controller(BlogsController::class)->group(function () {
    Route::get('/blogs', 'index')->name('admin.blog');
    Route::get('/blog/create', 'create')->name('admin.blogs.create');
    Route::post('/blogs/store', 'store')->name('admin.blogs.store');
    Route::get('/blog/{slug}/edit', 'edit')->name('admin.blogs.edit');
    Route::get('/blog/{slug}', 'show')->name('admin.blogs.show');
    Route::delete('/blog/destroy/{blog}','destroy')->name('admin.blogs.destroy');
    Route::put('/blog/update/{blog}', 'update')->name('admin.blogs.update');
});
// ======end of  blogs=========

Route::resources([
    'users'=>UserController::class,
    'roles'=>RoleController::class,
]);

Route::get('/roles/{roleId}/give-permission',[RoleController::class,'addPermissionToRole'])->name('add.permissions.to.role');
Route::post('/roles/{roleId}/give-permission',[RoleController::class,'givePermissionToRole'])->name('give.permission.to.role');
