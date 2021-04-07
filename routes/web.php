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
})->name('index');

Route::resource('master', 'App\Http\Controllers\MasterPasswordController')->middleware(['auth']);
Route::resource('password','App\Http\Controllers\PasswordController')->middleware(['auth']);
Route::resource('history','App\Http\Controllers\HistoryController')->middleware(['auth']);
Route::resource('datahistory','App\Http\Controllers\DataHistoryController')->middleware(['auth']);

require __DIR__.'/auth.php';
