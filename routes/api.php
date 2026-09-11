<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\KaterogiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index'])->name('product');
Route::post('/products', [ProductController::class, 'store'])->name('product.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/kategori', [KaterogiController::class, 'index'])->name('kategori');
Route::post('/kategori', [KaterogiController::class, 'store'])->name('kategori.store');
Route::put('/kategori/{kategori}', [KaterogiController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{kategori}', [KaterogiController::class, 'destroy'])->name('kategori.destroy');