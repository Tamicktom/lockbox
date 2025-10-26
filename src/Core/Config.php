<?php

namespace Tamicktom\Lockbox\Core;

final class Config
{
    private static array $config = [];

    public static function loadAll(string $configDirectoryPath): void
    {
        if (!is_dir($configDirectoryPath)) {
            return;
        }

        $files = glob(rtrim($configDirectoryPath, '/') . '/*.php') ?: [];
        foreach ($files as $file) {
            $key = basename($file, '.php');
            $data = require $file;
            if (is_array($data)) {
                self::$config[$key] = $data;
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = self::$config;
        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        return $value;
    }
}
