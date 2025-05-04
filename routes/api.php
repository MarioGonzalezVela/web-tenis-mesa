<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\VisitedLocationController;
use App\Http\Controllers\api\VideoController;
use App\Http\Controllers\api\FavoriteVideoController;

// Autentificación

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Rutas protegidas por Sanctum

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


// Resto de las rutas

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

// Rutas de carrito
Route::controller(CartController::class)->group(function () {
    Route::get('/carts', "index"); // pública: lista todos los carritos
    Route::get('/carts/{cartId}', 'show');
    Route::post('/carts', 'store');

    // Rutas protegidas: requiere autenticación
    Route::middleware('auth:sanctum')->post('/carts/{cartId}/add', 'addItem');
    Route::middleware('auth:sanctum')->delete('/carts/{cartId}/remove/{productId}', 'removeItem');
    Route::middleware('auth:sanctum')->put('/carts/{cartId}/update/{productId}', 'updateItem');
});

// Ruta protegida: obtener el carrito del usuario autenticado
Route::middleware('auth:sanctum')->get('/user/cart', [CartController::class, 'getUserCart']);

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

Route::controller(VideoController::class)->group(function () {
    Route::get('/videos', "index");
    Route::post('/videos', "store");
    Route::get('/videos/{id}', "show");
    Route::put('/videos/{id}', "update");
    Route::delete('/videos/{id}', "destroy");
});

Route::controller(FavoriteVideoController::class)->group(function () {
    Route::get('/favorite-videos', "index");
    Route::post('/favorite-videos', "store");
    Route::get('/favorite-videos/{id}', "show");
    Route::put('/favorite-videos/{id}', "update");
    Route::delete('/favorite-videos/{id}', "destroy");
});
