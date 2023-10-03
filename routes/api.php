<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/books', BookController::class);
    Route::get('/books/all', [BookController::class, 'showAll'])->name('books.all');
    Route::apiResource('/categories', CategoryController::class);

    Route::get('/profile', [AuthenticationController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::middleware(GuestMiddleware::class)->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
});



