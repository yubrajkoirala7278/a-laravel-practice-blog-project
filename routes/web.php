<?php

use App\Livewire\News;
use App\Livewire\NewsList;
use App\Livewire\NewsView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Auth::routes();

// admin livewire
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/news', News::class)->name('admin.news');
    Route::get('/admin/news/{id}', NewsView::class)->name('news.view');
});
// frontend livewire
Route::get('/news', NewsList::class)->name('news.list');
