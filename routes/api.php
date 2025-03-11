<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CustomerController;

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', "index");
    Route::post('/customers', "store");
    Route::get('/customers/{id}', "show");
    Route::put('/customers/{id}', "update");
    Route::delete('/customers/{id}', "destroy");
});
