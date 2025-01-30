<?php

use App\Http\Controllers\Extensions\Apcu;
use App\Http\Controllers\Extensions\GdController;
use App\Http\Controllers\Extensions\PdoMysqlController;
use App\Http\Controllers\Extensions\PdoPgsqlController;
use App\Http\Controllers\Extensions\PdoSqliteController;
use App\Http\Controllers\HelloWorld\HelloWorldController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelloWorldController::class, 'hello']);
Route::get('/query', [HelloWorldController::class, 'query']);
Route::post('/post', [HelloWorldController::class, 'post']);
Route::get('/server', [HelloWorldController::class, 'server']);
Route::get('/headers', [HelloWorldController::class, 'headers']);

# Extensions

# GD
Route::get('/gd/flush', [GdController::class, 'flushConvertedImages']);
Route::get('/gd/convert', [GdController::class, 'convertJpgToPng']);

# APCU
Route::post('/apcu', [Apcu::class, 'cache']);
Route::post('/apcu/flush', [Apcu::class, 'flush']);

# REDIS
Route::post('/redis', [\App\Http\Controllers\Extensions\Redis::class, 'cache']);
Route::post('/redis/flush', [\App\Http\Controllers\Extensions\Redis::class, 'flush']);

# PDO
Route::post('/pdo/mysql', [PdoMysqlController::class, 'insert']);
Route::post('/pdo/mysql/flush', [PdoMysqlController::class, 'flush']);
Route::get('/pdo/mysql/transaction', [PdoMysqlController::class, 'transaction']);

Route::post('/pdo/pgsql', [PdoPgsqlController::class, 'insert']);
Route::post('/pdo/pgsql/flush', [PdoPgsqlController::class, 'flush']);
Route::get('/pdo/pgsql/transaction', [PdoMysqlController::class, 'transaction']);

Route::post('/pdo/sqlite', [PdoSqliteController::class, 'insert']);
Route::post('/pdo/sqlite/flush', [PdoSqliteController::class, 'flush']);
Route::get('/pdo/sqlite/transaction', [PdoMysqlController::class, 'transaction']);
