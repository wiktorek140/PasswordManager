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

Route::get('/dashboard', 'App\Http\Controllers\Dashboard@index')
    ->middleware(['auth'])->name('dashboard');

Route::get('/passwords', 'App\Http\Controllers\PasswordController@index')
    ->middleware(['auth'])->name('passwords.index');

//Route::get('/password/store', 'App\Http\Controllers\PasswordController@storeView')->middleware(['auth'])->name('password.store');
Route::post('/password/store', 'App\Http\Controllers\PasswordController@store')->middleware(['auth'])->name('password.store');

Route::resource('password','App\Http\Controllers\PasswordController')->middleware(['auth']);
//Route::get('/password/delete', 'App\Http\Controllers\PasswordController@delete')->middleware(['auth'])->name('password.delete');


require __DIR__.'/auth.php';
