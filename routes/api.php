<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\VisitedLocationController;

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

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index');
    Route::get('/cart/{cartId}', 'show');
    Route::post('/cart', 'store');
    Route::post('/cart/{cartId}/add', 'addItem');
    Route::delete('/cart/{cartId}/remove/{productId}', 'removeItem');
    Route::put('/cart/{cartId}/update/{productId}', 'updateItem');
});

Route::controller(LocationController::class)->group(function () {
    Route::get('/locations', "index");
    Route::post('/locations', "store");
    Route::get('/locations/{id}', "show");
    Route::put('/locations/{id}', "update");
    Route::delete('/locations/{id}', "destroy");
});

Route::controller(VisitedLocationController::class)->group(function () {
    Route::get('/visited-locations', "index");
    Route::post('/visited-locations', "store");
    Route::get('/visited-locations/{id}', "show");
    Route::put('/visited-locations/{id}', "update");
    Route::delete('/visited-locations/{id}', "destroy");
});
