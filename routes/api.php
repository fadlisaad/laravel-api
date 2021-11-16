<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TreeController;

Route::middleware('auth:sanctum')->group( function () {
    
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('users', [AuthController::class, 'users']);
Route::delete('users/{id}', [AuthController::class, 'destroy']);

Route::get('trees', [TreeController::class, 'index']);
Route::get('trees/{id}', [TreeController::class, 'show']);
Route::post('trees/nearby', [TreeController::class, 'show']);
Route::post('trees', [TreeController::class, 'store']);