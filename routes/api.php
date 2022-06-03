<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);

Route::apiResource('products', ProductController::class, ['except' => 'update']);
Route::patch('/stores/{store}', [StoreSettingsController::class, 'update']);

Route::apiResource('cart-products', CartProductController::class);
