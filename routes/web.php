<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;

Route::group(['as' => 'news.', 'prefix' => '/'], function () {
    Route::get('/', [Controllers\PublicArea\NewsController::class, 'index'])->name('main');
    Route::post('/pagination', [Controllers\PublicArea\NewsController::class, 'setPaginationCount'])->name('pagination');
});


Auth::routes();

//user personal area
Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');

//admin panel and protected admin routes
Route::group(['middleware' => ['auth', 'admin'], 'namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    //admin menu
    Route::get('/', function () {
        return view('/admin/index');
    })->name('main');

    //news page
    Route::get('/news', [Controllers\Admin\NewsController::class, 'index'])->name('news');

    //NEWS CRUD
    Route::post('/news/delete', [Controllers\Admin\NewsController::class, 'newsDelete'])->name('news.delete');
    Route::post('/news/edit', [Controllers\Admin\NewsController::class, 'newsEdit'])->name('news.edit');
    Route::post('/news/update', [Controllers\Admin\NewsController::class, 'updateNews'])->name('news.update');
    Route::post('/news/save', [Controllers\Admin\NewsController::class, 'saveNews'])->name('news.save');
});
