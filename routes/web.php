<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function () {
        return view('/admin/index');
    })->name('main');

    Route::get('/news', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('news');
    Route::get(
        '/news/draw',
        [App\Http\Controllers\Admin\NewsController::class, 'drawNewsTable']
    )->name('news.table');

});
