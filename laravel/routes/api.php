<?php

use App\Http\Controllers\Extensions\Apcu;
use App\Http\Controllers\Extensions\Curl;
use App\Http\Controllers\Extensions\Gd;
use App\Http\Controllers\Extensions\Intl;
use App\Http\Controllers\Extensions\PdoMysql;
use App\Http\Controllers\Extensions\PdoPgsql;
use App\Http\Controllers\Extensions\PdoSqlite;
use App\Http\Controllers\HelloWorld\HelloWorldController;
use App\Http\Controllers\HelloWorld\ThrowController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelloWorldController::class, 'hello']);
Route::get('/query', [HelloWorldController::class, 'query']);
Route::post('/post', [HelloWorldController::class, 'post']);
Route::get('/server', [HelloWorldController::class, 'server']);
Route::get('/headers', [HelloWorldController::class, 'headers']);
Route::get('/sleep', [HelloWorldController::class, 'sleep']);

Route::get('/throw', [ThrowController::class, 'throw']);
Route::get('/abort', [ThrowController::class, 'abort']);

# Extensions

# GD
Route::get('/gd/flush', [Gd::class, 'flushConvertedImages']);
Route::get('/gd/convert', [Gd::class, 'convertJpgToPng']);

# APCU
Route::post('/apcu', [Apcu::class, 'cache']);
Route::post('/apcu/flush', [Apcu::class, 'flush']);

# REDIS
Route::post('/redis', [\App\Http\Controllers\Extensions\Redis::class, 'cache']);
Route::post('/redis/flush', [\App\Http\Controllers\Extensions\Redis::class, 'flush']);

# INTL
Route::get('/intl', [Intl::class, 'calendar']);

# CURL
Route::get('/curl', [Curl::class, 'fetch']);

# PDO
Route::post('/pdo/mysql', [PdoMysql::class, 'insert']);
Route::post('/pdo/mysql/flush', [PdoMysql::class, 'flush']);
Route::get('/pdo/mysql/transaction', [PdoMysql::class, 'transaction']);

Route::post('/pdo/pgsql', [PdoPgsql::class, 'insert']);
Route::post('/pdo/pgsql/flush', [PdoPgsql::class, 'flush']);
Route::get('/pdo/pgsql/transaction', [PdoMysql::class, 'transaction']);

Route::post('/pdo/sqlite', [PdoSqlite::class, 'insert']);
Route::post('/pdo/sqlite/flush', [PdoSqlite::class, 'flush']);
Route::get('/pdo/sqlite/transaction', [PdoMysql::class, 'transaction']);
