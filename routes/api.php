<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/account/applications', [AccountController::class, 'applications']);
    Route::get('/account/reviews', [AccountController::class, 'reviews']);

    Route::prefix('products/{product:slug}/application')
        ->name('products.application')
        ->controller(ApplicationController::class)
        ->group(function () {
            Route::get('/', 'show')->name('show');
            Route::post('/', 'store')->name('store');
            Route::post('/cancel', 'cancel')->name('cancel');
        });

    Route::prefix('products/{product:slug}')
        ->name('products.')
        ->group(function () {
            Route::prefix('/application')
                ->name('application')
                ->controller(ApplicationController::class)
                ->group(function () {
                    Route::get('/', 'show')->name('show');
                    Route::post('/', 'store')->name('store');
                    Route::post('/cancel', 'cancel')->name('cancel');
                });

            Route::post('/reviews', [ReviewController::class, 'store'])
                ->name('reviews.store');
        });
});

Route::prefix('products')
    ->name('products.')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/filters', 'getFilters')->name('filters');
        Route::get('/{product:slug}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/{product:slug}', 'show')->name('show');
    });

Route::prefix('posts')
    ->name('posts.')
    ->controller(PostController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{post:slug}', 'show')->name('show');
    });
