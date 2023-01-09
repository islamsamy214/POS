<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


require __DIR__ . '/auth.php';
Route::resource('users', UserController::class)->except('show');
Route::resource('brands', BrandController::class)->except(['create', 'show']);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class)->except('create');
Route::put('change-order-status/{order}', [OrderController::class, 'changeOrderStatus']);
