<?php

use App\Http\Controllers\OrderController;
//use App\Http\Controllers\OrderPositionController;
use App\Http\Controllers\ProductController;
use App\Models\OrderPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderPositionCountController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('user', UserController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('order', OrderController::class)->except(['destroy']);

Route::controller(OrderPositionCountController::class)->group(function (){
    Route::prefix('order-position')->group(function (){
        Route::post('add-product', 'add');
        Route::put('remove-product', 'remove');
    });
});
