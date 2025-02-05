<?php

use App\Http\Controllers\Extensions\Apcu;
use App\Http\Controllers\Extensions\Curl;
use App\Http\Controllers\Extensions\Exif;
use App\Http\Controllers\Extensions\Fiber;
use App\Http\Controllers\Extensions\Gd;
use App\Http\Controllers\Extensions\Gmp;
use App\Http\Controllers\Extensions\Intl;
use App\Http\Controllers\Extensions\MysqliExt;
use App\Http\Controllers\Extensions\OpCache;
use App\Http\Controllers\Extensions\OpenSSL;
use App\Http\Controllers\Extensions\Pdo;
use App\Http\Controllers\Extensions\Redis;
use App\Http\Controllers\Extensions\Xml;
use App\Http\Controllers\Extensions\Zip;
use App\Http\Controllers\Laravel\Encrypt;
use App\Http\Controllers\Laravel\FileCache;
use App\Http\Controllers\Laravel\Hash;
use App\Http\Controllers\Laravel\HelloWorld;
use App\Http\Controllers\Laravel\Template;
use App\Http\Controllers\Laravel\Abort;
use App\Http\Controllers\Laravel\Upload;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelloWorld::class, 'hello']);
Route::get('/query', [HelloWorld::class, 'query']);
Route::post('/post', [HelloWorld::class, 'post']);
Route::get('/server', [HelloWorld::class, 'server']);
Route::get('/headers', [HelloWorld::class, 'headers']);
Route::get('/sleep', [HelloWorld::class, 'sleep']);
Route::get('/timeout', [HelloWorld::class, 'timeout']);
Route::get('/table', [Template::class, 'table']);
Route::get('/encrypt', [Encrypt::class, 'encrypt']);
Route::get('/decrypt', [Encrypt::class, 'decrypt']);
Route::get('/hash', [Hash::class, 'hash']);
Route::get('/mysqli', [MysqliExt::class, 'query']);
Route::get('/mysqli/denied', [MysqliExt::class, 'accessDenied']);

Route::get('/throw', [Abort::class, 'throw']);
Route::get('/dd', [Abort::class, 'dd']);
Route::get('/abort', [Abort::class, 'abort']);

Route::post('/filecache', [FileCache::class, 'cache']);
Route::post('/filecache/flush', [FileCache::class, 'flush']);

Route::post('/upload', [Upload::class, 'upload']);
Route::post('/upload/flush', [Upload::class, 'flush']);


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

# EXIF
Route::get('/exif', [Exif::class, 'type']);

# FIBER
Route::get('/fiber', [Fiber::class, 'start']);

# OPENSSL
Route::get('/openssl', [OpenSSL::class, 'encrypt']);
Route::get('/bcrypt', [OpenSSL::class, 'bcrypt']);

# PDO
Route::post('/pdo/{driver}', [Pdo::class, 'insert']);
Route::post('/pdo/{driver}/flush', [Pdo::class, 'flush']);
Route::get('/pdo/{driver}/transaction', [Pdo::class, 'transaction']);
