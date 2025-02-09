#!/usr/bin/env php
<?php

function xhprof_get_args($argv)
{
    array_shift($argv);
    return array_values(
        array_filter($argv, function ($arg) {
            return strpos($arg, "-") !== 0;
        })
    );
}

$args = xhprof_get_args($argv);
$dir = $args[0];
$files = glob("$dir/*.xhprof");


$stacks = array();

$ignore = 'main()==>frankenphp_handle_request';

foreach ($files as $index => $file) {
    $raw_xhprof = @unserialize(file_get_contents($file));
    foreach ($raw_xhprof as $stack) {
        if ($stack === $ignore) {
            continue;
        }

        $stack_key = implode(";", explode("==>", $stack));
        $stacks[$stack_key] = 1 + ($stacks[$stack_key] ?? 0);
    }
}

foreach ($stacks as $stack => $count) {
    print "$stack $count" . PHP_EOL;
}
