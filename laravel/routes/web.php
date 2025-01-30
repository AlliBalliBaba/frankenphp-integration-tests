<?php

use App\Http\Controllers\Laravel\AuthenticatedRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/session', [App\Http\Controllers\Laravel\HelloWorldController::class, 'hello']);


# Simulate Login Flow
Route::get('/auth/login', [AuthenticatedRequestController::class, 'login']);
Route::get('/auth/profile', [AuthenticatedRequestController::class, 'profile']);
