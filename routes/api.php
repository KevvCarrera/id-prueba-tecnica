<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(RegisterController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
         

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::middleware('permission:list-product')->get('/products', [ProductController::class, 'index']);
    Route::middleware('permission:create-product')->post('/products', [ProductController::class, 'store']);
    Route::middleware('permission:update-product')->put('/products/{product}', [ProductController::class, 'update']);
    Route::middleware('permission:delete-product')->delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::middleware('permission:list-sales')->get('/sales', [SaleController::class, 'index']);
    Route::middleware('permission:create-sales')->post('/sales', [SaleController::class, 'store']);
    Route::middleware('permission:update-sales')->put('/sales/{sale}', [SaleController::class, 'update']);
    Route::middleware('permission:delete-sales')->delete('/sales/{sale}', [SaleController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/sales-report', [SaleReportController::class, 'generateReport']);
});
