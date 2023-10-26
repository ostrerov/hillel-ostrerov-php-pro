<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentSystemController;
use App\Http\Middleware\GuestMiddleware;
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
    Route::get('/booksIterator', [BookController::class, 'getDataByIterator'])->name('books.indexByIterator');
    Route::get('/booksModel', [BookController::class, 'getDataByModel'])->name('books.indexByModel');
    Route::get('/books/all', [BookController::class, 'showAll'])->name('books.all');
    Route::apiResource('/books', BookController::class);
    Route::get('/categoryIterator/{category}', [CategoryController::class, 'showIterator'])
        ->name('categories.showIterator');
    Route::get('/categoryModel/{category}', [CategoryController::class, 'showModel'])
        ->name('books.showByModel');
    Route::apiResource('/categories', CategoryController::class);

    Route::get('/profile', [AuthenticationController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('/categoriesCache', [CategoryController::class, 'cachedIndex'])->name('categories.cachedIndex');
});

Route::get('payment/makePayment/{system}', [PaymentSystemController::class, 'createPayment'])->name('payment.create');
Route::post('payment/confirm/{system}', [PaymentSystemController::class, 'confirmPayment'])
    ->name('payment.confirm');

Route::middleware(GuestMiddleware::class)->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
});



