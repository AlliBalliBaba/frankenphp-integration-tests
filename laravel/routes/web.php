<?php

use App\Http\Controllers\Laravel\AuthenticatedRequestController;
use App\Http\Controllers\Laravel\SessionController;
use Illuminate\Support\Facades\Route;

# Simulate session flow (note: GET to circumvent CSRF)
Route::get('/session/{driver}', [SessionController::class, 'get']);
Route::get('/session/{driver}/put', [SessionController::class, 'put']);


# Simulate Login Flow
Route::get('/auth/login', [AuthenticatedRequestController::class, 'login']);
Route::get('/auth/profile', [AuthenticatedRequestController::class, 'profile']);
