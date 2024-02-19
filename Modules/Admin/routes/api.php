<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\ChapterContentController;
use Modules\Admin\App\Http\Controllers\ChapterController;
use Modules\Admin\App\Http\Controllers\ComicController;
use Modules\Admin\App\Http\Controllers\ComicGenreController;
use Modules\Admin\App\Http\Controllers\GenreController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('admin', fn (Request $request) => $request->user())->name('admin');
// });



Route::prefix('/admin')->group(function () {
    Route::prefix('/comic')->group(function () {
        Route::get('/get', [ComicController::class, 'get'])->name('get.comic');
        Route::post('/create', [ComicController::class, 'create'])->name('create.comic');
        Route::put('/update/{id}', [ComicController::class, 'update'])->name('update.comic');
        Route::delete('/delete/{id}', [ComicController::class, 'destroy'])->name('delete.comic');
    });

    Route::prefix('/genre')->group(function () {
        Route::get('/get', [GenreController::class, 'get'])->name('get.genre');
        Route::post('/create', [GenreController::class, 'create'])->name('create.genre');
        Route::put('/update/{id}', [GenreController::class, 'update'])->name('update.genre');
        Route::delete('/delete/{id}', [GenreController::class, 'destroy'])->name('delete.genre');
    });


    Route::prefix('/chapter')->group(function () {
        Route::get('/get', [ChapterController::class, 'get'])->name('get.chapter');
        Route::post('/create', [ChapterController::class, 'create'])->name('create.chapter');
        Route::put('/update/{id}', [ChapterController::class, 'update'])->name('update.chapter');
        Route::delete('/delete/{id}', [ChapterController::class, 'destroy'])->name('delete.chapter');
    });

    Route::prefix('/chapter-content')->group(function () {
        Route::get('/get', [ChapterContentController::class, 'get'])->name('get.chapter_content');
        Route::post('/create', [ChapterContentController::class, 'create'])->name('create.chapter_content');
        Route::put('/update/{id}', [ChapterContentController::class, 'update'])->name('update.chapter_content');
        Route::delete('/delete/{id}', [ChapterContentController::class, 'destroy'])->name('delete.chapter_content');
    });

    Route::prefix('/comic-genre')->group(function () {
        Route::get('/get', [ComicGenreController::class, 'get'])->name('get.comic_genre');
        Route::post('/create', [ComicGenreController::class, 'create'])->name('create.comic_genre');
        Route::put('/update/{id}', [ComicGenreController::class, 'update'])->name('update.comic_genre');
        Route::delete('/delete/{id}', [ComicGenreController::class, 'destroy'])->name('delete.comic_genre');
    });
});
