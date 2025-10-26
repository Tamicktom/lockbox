<?php

namespace Tamicktom\Lockbox\Http\Controllers;

use Tamicktom\Lockbox\Core\Request;
use Tamicktom\Lockbox\Core\View;

class HomeController
{
    /**
     * Summary of index
     * @param Request $request
     * @param array<string, string> $params
     * @return string
     * @throws \RuntimeException
     */
    public function index(Request $request, array $params = []): string
    {
        $appName = config('app.name', 'Lockbox');
        if (!is_string($appName)) {
            $appName = 'Lockbox';
        }
        return View::render('home', [
            'appName' => $appName,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
