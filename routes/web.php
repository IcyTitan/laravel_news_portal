<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
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

Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function () {
        return view('/admin/index');
    })->name('main');

    Route::get('/news', [Controllers\Admin\NewsController::class, 'index'])->name('news');
    Route::get(
        '/news/draw',
        [Controllers\Admin\NewsController::class, 'drawNewsTable']
    )->name('news.table');
    Route::post('/news/delete', [Controllers\Admin\NewsController::class, 'newsDelete'])->name('news.delete');
    Route::post('/news/edit', [Controllers\Admin\NewsController::class, 'newsEdit'])->name('news.edit');
    Route::post('/news/update', [Controllers\Admin\NewsController::class, 'updateNews'])->name('news.update');
    Route::post('/news/save', [Controllers\Admin\NewsController::class, 'saveNews'])->name('news.save');
});
