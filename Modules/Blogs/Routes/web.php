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

// ====frontend==========
require __DIR__.'/public.php';
// ======================

// =======backend=======
Route::prefix('admin')->group(function(){
    require __DIR__.'/admin.php';
});
// =====================

