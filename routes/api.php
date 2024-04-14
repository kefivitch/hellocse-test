<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.v1.')->group(function () {
    
    // Auth routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum')
    ->name('user');

    // Profile routes
    Route::prefix('profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [ProfileController::class, 'store'])->middleware('auth:sanctum')->name('profiles.store');
            Route::post('/{profile}/comments', [CommentController::class, 'store'])->name('profiles.comments.store');
            Route::put('/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
            Route::delete('/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
        });
    });
});
