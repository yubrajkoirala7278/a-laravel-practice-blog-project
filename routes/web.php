<?php

use App\Http\Controllers\SmsTwilioController;
use App\Livewire\News;
use App\Livewire\NewsList;
use App\Livewire\NewsView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Auth::routes();

// admin livewire
Route::group(['middleware'=>['role:super_admin|admin|blog_manager|news_manager']],function(){
        Route::get('/admin/news', News::class)->name('admin.news');
        Route::get('/admin/news/{id}', NewsView::class)->name('news.view');
});
// frontend livewire
Route::get('/news', NewsList::class)->name('news.list');

// twilio sending sms
Route::get('sms/send', [SmsTwilioController::class, 'sendSms']);
