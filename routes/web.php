<?php

use Tamicktom\Lockbox\Http\Controllers\HomeController;

/** @var \Tamicktom\Lockbox\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);


