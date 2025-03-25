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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/item_regist', [App\Http\Controllers\HomeController::class, 'item_regist'])->name('regist');
Route::post('/insert', [App\Http\Controllers\HomeController::class, 'insert_item'])->name('insert');
Route::match(['GET', 'POST'],'/detail/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail');
Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update_item'])->name('update');
Route::post('/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_item'])->name('delete');
// Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
// Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::match(['GET', 'POST'],'/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

