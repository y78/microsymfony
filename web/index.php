<?php

require_once __DIR__ . '/vendor/autoload.php';
use Yarik\MicroSymfony\Component\HttpFoundation;

//require_once __DIR__ . '/app/cache.hard.php';
//$kernel = new \Cache\CacheKernel(null);
require_once __DIR__ . '/app/AppKernel.php';
$kernel = new AppKernel();

$request = new HttpFoundation\Request();
$response = $kernel->handleRequest($request);
$response->send();
