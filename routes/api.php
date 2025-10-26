<?php

/** @var \Tamicktom\Lockbox\Core\Router $router */

$router->get('/api/hello', fn($request, $params) => ['message' => 'hello world']);


