<?php

use App\Http\Controllers\Laravel\AuthenticatedRequest;
use App\Http\Controllers\Laravel\Session;
use Illuminate\Support\Facades\Route;

# Simulate session flow (note: GET to circumvent CSRF)
Route::get('/session/{driver}', [Session::class, 'get']);
Route::get('/session/{driver}/put', [Session::class, 'put']);


# Simulate Login Flow
Route::get('/auth/login', [AuthenticatedRequest::class, 'login']);
Route::get('/auth/profile', [AuthenticatedRequest::class, 'profile']);
