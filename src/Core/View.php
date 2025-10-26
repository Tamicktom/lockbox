<?php

namespace Tamicktom\Lockbox\Core;

class View
{
    public static function render(string $view, array $data = []): string
    {
        $file = view_path($view . '.php');
        if (!file_exists($file)) {
            throw new \RuntimeException('View not found: ' . $file);
        }
        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return (string) ob_get_clean();
    }
}
