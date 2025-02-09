<?php

// Set a default for the application base path and public path if they are missing...
$_SERVER['APP_BASE_PATH'] = $_ENV['APP_BASE_PATH'] ?? $_SERVER['APP_BASE_PATH'] ?? __DIR__ . '/..';
$_SERVER['APP_PUBLIC_PATH'] = $_ENV['APP_PUBLIC_PATH'] ?? $_SERVER['APP_BASE_PATH'] ?? __DIR__;
$_SERVER['MAX_REQUESTS'] = 1000;

$isProfiling = ($_ENV['PROFILING'] ?? $_SERVER['PROFILING'] ?? '') === 'on';

if($isProfiling){
    xhprof_sample_enable();
}

require __DIR__ . '/../vendor/laravel/octane/bin/frankenphp-worker.php';

if($isProfiling){
    $filename = "/profile/" . uniqid() . ".xhprof";
    file_put_contents($filename, serialize(xhprof_sample_disable()));
    chmod($filename, 0777);
}
