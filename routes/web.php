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
Route::get('/playtrailer/{id}', [App\Http\Controllers\SpringboardController::class, 'playTrailer'])->name('playtrailer');


//Admin Routes
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('search.movies');

Route::get('/add', [App\Http\Controllers\AdminController::class, 'create'])->name('create');

Route::post('/store_s1', [App\Http\Controllers\AdminController::class, 'store_s1'])->name('store.s1');
Route::post('/store_s2', [App\Http\Controllers\AdminController::class, 'store_s2'])->name('store.s2');
Route::post('/store_s2e', [App\Http\Controllers\AdminController::class, 'store_s2e'])->name('store.s2e');
Route::post('/store_s3', [App\Http\Controllers\AdminController::class, 'store_s3'])->name('store.s3');
Route::post('/store_s3e', [App\Http\Controllers\AdminController::class, 'store_s3e'])->name('store.s3e');
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

route::get('watchers', [App\Http\Controllers\SpringboardController::class, 'watchers'])->name('inc.watchers');
// route::get('drama', [App\Http\Controllers\SpringboardController::class, 'drama'])->name('inc.drama');
// route::get('action', [App\Http\Controllers\SpringboardController::class, 'action'])->name('inc.action');
// route::get('crime_thriller', [App\Http\Controllers\SpringboardController::class, 'crime_thriller'])->name('inc.crime_thriller');
// route::get('comedy', [App\Http\Controllers\SpringboardController::class, 'comedy'])->name('inc.comedy');
// route::get('scifi', [App\Http\Controllers\SpringboardController::class, 'scifi'])->name('inc.scifi');
// route::get('faith_family', [App\Http\Controllers\SpringboardController::class, 'faith_family'])->name('inc.faith_family');
// route::get('horror', [App\Http\Controllers\SpringboardController::class, 'horror'])->name('inc.horror');
// route::get('romance', [App\Http\Controllers\SpringboardController::class, 'romance'])->name('inc.romance');
// route::get('classical', [App\Http\Controllers\SpringboardController::class, 'classical'])->name('inc.classical');


route::get('thumbnails/{id}', [App\Http\Controllers\SpringboardController::class, 'thumbnails'])->name('inc.thumbnails');
route::get('thumbnails_series/{id}', [App\Http\Controllers\SpringboardController::class, 'thumbnails_series'])->name('inc.series_link');

//Tracker routes
Route::get('/tracker_update', function () {
    return view('trackers.tracker_update');
});
