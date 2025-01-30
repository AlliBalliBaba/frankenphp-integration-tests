<?php

use Illuminate\Support\Facades\Route;

Route::get('/session', [App\Http\Controllers\Laravel\HelloWorldController::class, 'hello']);
