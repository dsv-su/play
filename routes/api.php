<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\VideoApiController;

Route::get('test', [AuthController::class, 'token_test']);

// Issue tokens
Route::post('token_store', [AuthController::class, 'store']);
Route::post('token_read', [AuthController::class, 'read']);

// Invalidate tokens
Route::post('destroy', [AuthController::class, 'logout']);

// Refresh token (optional)
// Route::post('refresh', [AuthController::class, 'refresh']);

// Store
Route::apiResource('recordings', VideoApiController::class);

// Check permissions
Route::get('permissions/{id}', [VideoApiController::class, 'permissions']);

// Check permissions with ticket
Route::get('ticket/{id}', [VideoApiController::class, 'perm']);
Route::post('perm', [VideoApiController::class, 'permission']);

