<?php

require_once __DIR__ . '/vendor/autoload.php';

use Yarik\MicroSymfony\Component\HttpFoundation;

$time = microtime(true) * 1000;

$request = new HttpFoundation\Request();
$router = new HttpFoundation\Router($request);
$router
    ->addRoute('first', '/first/{slug}-{id}')
    ->addRoute('first_second', '/first/second/{slug}-{id}')
    ->addRoute('first_second_edit', '/first/second/{slug}-{id}/edit')
;

$result = $router->getRoute();
var_dump($result);

var_dump(microtime(true) * 1000 - $time);

