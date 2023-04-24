<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/products', [ProductController::class, 'listProducts']);
Route::get('/products/{slug}', [ProductController::class, 'getProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
