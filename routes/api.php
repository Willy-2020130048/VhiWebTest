<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\checkVendor;
use App\Http\Middleware\checkAdmin;

// Endpoint auth user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vendors', [VendorController::class, 'index']);
Route::get('/products', [ProductController::class, 'indexForUser']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('vendors', VendorController::class)->except(['index']);

    Route::middleware('checkVendor')->group(function () {
        Route::apiResource('/vendor/products', ProductController::class);
        Route::get('/vendor/my-products', [ProductController::class, 'indexByVendor']);
        Route::post('/vendor/my-products/{id}/status', [ProductController::class, 'changeStatus']);
    });

    Route::middleware('checkVendor')->group(function () {
        Route::post('/vendors/{id}/status', [VendorController::class, 'changeStatus']);
    });
});