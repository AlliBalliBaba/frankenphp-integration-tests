<?php

use Illuminate\Support\Facades\Route;

Route::get('/session', [App\Http\Controllers\HelloWorld\HelloWorldController::class, 'hello']);
