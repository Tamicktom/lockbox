<?php

//* Controllers
use Tamicktom\Lockbox\Http\Controllers\HomeController;

/** @var \Tamicktom\Lockbox\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/hello', fn($request, $params) => ['message' => 'hello world']);
