<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\SpringboardController::class, 'welcome']);
Route::get('/', [App\Http\Controllers\SpringboardController::class, 'index'])->name('home');
Route::get('/play/{id}', [App\Http\Controllers\SpringboardController::class, 'playView'])->name('play');
Route::get('/more_info/{id}', [App\Http\Controllers\SpringboardController::class, 'moreInfo'])->name('more_info');


//Admin Routes
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('search.movies');

Route::get('/add', [App\Http\Controllers\AdminController::class, 'create'])->name('create');

Route::post('/store_s1', [App\Http\Controllers\AdminController::class, 'store_s1'])->name('store.s1');
Route::post('/store_s2', [App\Http\Controllers\AdminController::class, 'store_s2'])->name('store.s2');
Route::post('/store_s3', [App\Http\Controllers\AdminController::class, 'store_s3'])->name('store.s3');
Route::post('/store_s4', [App\Http\Controllers\AdminController::class, 'store_s4'])->name('store.s4');
Route::post('/store_s5', [App\Http\Controllers\AdminController::class, 'store_s5'])->name('store.s5');


Route::get('/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('edit');
Route::post('/update_s1/{id}', [App\Http\Controllers\AdminController::class, 'update_s1'])->name('update.s1');
Route::post('/update_s2/{id}', [App\Http\Controllers\AdminController::class, 'update_s2'])->name('update.s2');
Route::post('/update_s3/{id}', [App\Http\Controllers\AdminController::class, 'update_s3'])->name('update.s3');
Route::post('/update_s4/{id}', [App\Http\Controllers\AdminController::class, 'update_s4'])->name('update.s4');
Route::post('/update_s5/{id}', [App\Http\Controllers\AdminController::class, 'update_s5'])->name('update.s5');
Route::get('/view/{id}', [App\Http\Controllers\AdminController::class, 'show'])->name('show');
Route::post('/skip', [App\Http\Controllers\AdminController::class, 'skip'])->name('skip');

Route::get('/view_all', [App\Http\Controllers\AdminController::class, 'show_all'])->name('show_all');
Route::post('/billboard_show', [App\Http\Controllers\AdminController::class, 'billboardShow'])->name('billboard.show');


//Tracker routes
Route::get('/tracker_update', function () {
    return view('trackers.tracker_update');
});
Route::get('/tracker_data', function () {
    return view('trackers.tracker_data');
});
Route::get('/tracker_check', function () {
    return view('trackers.tracker_check');
});