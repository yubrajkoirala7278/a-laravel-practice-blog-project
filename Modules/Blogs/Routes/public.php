<?php


use Illuminate\Support\Facades\Route;
use Modules\Blogs\Http\Controllers\Frontend\HomeController;

Route::get('/', [HomeController::class,'index'])->name('home');