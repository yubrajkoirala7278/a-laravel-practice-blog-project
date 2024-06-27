<?php

use App\Livewire\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Auth::routes();
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/news', News::class)->name('admin.news');
});
