<?php

use App\Http\Controllers\Api\ProductController;
<<<<<<< HEAD
use App\Http\Controllers\Api\AuthController;
=======
use App\Http\Controllers\Api\KaterogiController;
>>>>>>> be5a6e79d4f2bd30130c10887e9866f90cfff3cd
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');


    Route::middleware('jwt')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('user', [AuthController::class, 'user'])->name('user');
    });
});


Route::middleware('jwt')->group(function () {
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('product', ProductController::class);
});
