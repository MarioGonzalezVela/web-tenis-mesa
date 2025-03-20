<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ProductController;

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', "index");
    Route::post('/customers', "store");
    Route::get('/customers/{id}', "show");
    Route::put('/customers/{id}', "update");
    Route::delete('/customers/{id}', "destroy");
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', "index");
    Route::post('/products', "store");
    Route::get('/products/{id}', "show");
    Route::put('/products/{id}', "update");
    Route::delete('/products/{id}', "destroy");
});
