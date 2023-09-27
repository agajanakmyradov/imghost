<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
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

Auth::routes(['verify' => true]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('images')->group(function() {
    Route::get('/', [ImageController::class, 'index'])->name('images.index');

    Route::get('/create', [ImageController::class, 'create'])->name('images.create');

    Route::post('/store', [ImageController::class, 'store'])->middleware(['auth', 'verified'])->name('images.store');

    Route::get('/destroy/{id}', [ImageController::class, 'destroy'])->middleware('auth')->name('images.destroy');


});

Route::prefix('user')->group(function() {
    Route::get('/api', [UserController::class, 'api'])->name('user.api');

    Route::get('/api/change', [UserController::class, 'changeApi'])->name('user.api.change');

});
