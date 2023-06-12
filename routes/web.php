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
