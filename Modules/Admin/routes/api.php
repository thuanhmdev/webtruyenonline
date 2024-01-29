<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\ComicController;
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

Route::get('/admin/comic/get', [ComicController::class, 'get'])->name('get.comic');
Route::post('/admin/comic/create', [ComicController::class, 'create'])->name('create.comic');
Route::put('/admin/comic/update/{id}', [ComicController::class, 'update'])->name('update.comic');
Route::delete('/admin/comic/delete/{id}', [ComicController::class, 'destroy'])->name('delete.comic');


Route::get('/admin/genre/get', [GenreController::class, 'get'])->name('get.genre');
Route::post('/admin/genre/create', [GenreController::class, 'create'])->name('create.genre');
Route::put('/admin/genre/update/{id}', [GenreController::class, 'update'])->name('update.genre');
Route::delete('/admin/genre/delete/{id}', [GenreController::class, 'destroy'])->name('delete.genre');
