<?php

use App\Http\Controllers\v1\ProductController;
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

Route::controller(ProductController::class)->group(function () {
    Route::post('/products', 'store');
    Route::get('/products', 'list');
    Route::get('/products/{product}', 'show');
    Route::get('/products/{product}/history', 'history');
    Route::put('/products/{product}', 'update');
    Route::put('/products/{product}/{action}', 'inventory');
    Route::delete('/products/{product}', 'delete');
});
