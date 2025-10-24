<?php

use App\Http\Controllers\Api\PresentationApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('test', [AuthController::class, 'token_test']);

// Issue tokens
Route::post('token_store', [AuthController::class, 'store']);
Route::post('token_read', [AuthController::class, 'read']);

// Invalidate tokens
Route::post('destroy', [AuthController::class, 'logout']);

// Refresh token (optional)
// Route::post('refresh', [AuthController::class, 'refresh']);

// Store
Route::apiResource('recordings', PresentationApiController::class);

// Check permissions
Route::get('permissions/{id}', [PresentationApiController::class, 'permissions']);

// Check permissions with ticket
Route::get('ticket/{id}', [PresentationApiController::class, 'perm']);
Route::post('perm', [PresentationApiController::class, 'permission']);
