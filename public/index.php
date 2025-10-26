<?php

declare(strict_types=1);

use Tamicktom\Lockbox\Bootstrap;
use Tamicktom\Lockbox\Core\Request;
use Tamicktom\Lockbox\Core\Response;
use Tamicktom\Lockbox\Core\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

Bootstrap::init();

$request = Request::fromGlobals();
$response = new Response();
$router = new Router();

// Register routes
require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/api.php';

$result = $router->dispatch($request);

if ($result === null) {
    $response->status(404)->send('404 Not Found');
    return;
}

if ($result instanceof Response) {
    // Handler already sent the response
    return;
}

if (is_array($result)) {
    $response->json($result);
    return;
}

$response->header('Content-Type', 'text/html; charset=utf-8')->send((string) $result);


