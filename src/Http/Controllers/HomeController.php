<?php

namespace Tamicktom\Lockbox\Http\Controllers;

use Tamicktom\Lockbox\Core\Request;
use Tamicktom\Lockbox\Core\View;

class HomeController
{
    public function index(Request $request, array $params = []): string
    {
        return View::render('home', [
            'appName' => (string) config('app.name', 'Lockbox'),
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
