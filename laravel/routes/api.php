<?php

use App\Http\Controllers\Extensions\Apcu;
use App\Http\Controllers\Extensions\Curl;
use App\Http\Controllers\Extensions\Gd;
use App\Http\Controllers\Extensions\Gmp;
use App\Http\Controllers\Extensions\Intl;
use App\Http\Controllers\Extensions\OpCache;
use App\Http\Controllers\Extensions\OpenSSL;
use App\Http\Controllers\Extensions\Pdo;
use App\Http\Controllers\Extensions\Redis;
use App\Http\Controllers\Extensions\Xml;
use App\Http\Controllers\Extensions\Zip;
use App\Http\Controllers\Laravel\FileCacheController;
use App\Http\Controllers\Laravel\HelloWorldController;
use App\Http\Controllers\Laravel\TemplateController;
use App\Http\Controllers\Laravel\ThrowController;
use App\Http\Controllers\Laravel\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelloWorldController::class, 'hello']);
Route::get('/query', [HelloWorldController::class, 'query']);
Route::post('/post', [HelloWorldController::class, 'post']);
Route::get('/server', [HelloWorldController::class, 'server']);
Route::get('/headers', [HelloWorldController::class, 'headers']);
Route::get('/sleep', [HelloWorldController::class, 'sleep']);
Route::get('/table', [TemplateController::class, 'table']);

Route::get('/throw', [ThrowController::class, 'throw']);
Route::get('/abort', [ThrowController::class, 'abort']);

Route::post('/filecache', [FileCacheController::class, 'cache']);
Route::post('/filecache/flush', [FileCacheController::class, 'flush']);

Route::post('/upload', [UploadController::class, 'upload']);
Route::post('/upload/flush', [UploadController::class, 'flush']);


# Extensions

# GD
Route::get('/gd/flush', [Gd::class, 'flushConvertedImages']);
Route::get('/gd/convert', [Gd::class, 'convertJpgToPng']);

# APCU
Route::post('/apcu', [Apcu::class, 'cache']);
Route::post('/apcu/flush', [Apcu::class, 'flush']);

# REDIS
Route::post('/redis', [Redis::class, 'cache']);
Route::post('/redis/flush', [Redis::class, 'flush']);

# ZIP
Route::post('/zip', [Zip::class, 'zip']);
Route::post('/zip/flush', [Zip::class, 'flush']);

# INTL
Route::get('/intl', [Intl::class, 'calendar']);

# CURL
Route::get('/curl', [Curl::class, 'fetch']);

# OPCACHE
Route::get('/opcache/flush', [OpCache::class, 'flush']);

# GMP
Route::get('/gmp', [Gmp::class, 'convert']);

# XML
Route::post('/xml', [Xml::class, 'convert']);

# OPENSSL
Route::get('/openssl', [OpenSSL::class, 'encrypt']);

# PDO
Route::post('/pdo/{driver}', [Pdo::class, 'insert']);
Route::post('/pdo/{driver}/flush', [Pdo::class, 'flush']);
Route::get('/pdo/{driver}/transaction', [Pdo::class, 'transaction']);
