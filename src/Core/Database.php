<?php

namespace Tamicktom\Lockbox\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $default = Config::get('database.default', 'mysql');
        $config = Config::get('database.connections.' . $default);

        if (!is_array($config) || !isset($config['driver'])) {
            throw new \RuntimeException('Database configuration is missing or invalid.');
        }

        $driver = (string) $config['driver'];
        $options = $config['options'] ?? [];

        try {
            switch ($driver) {
                case 'mysql':
                    $dsn = sprintf(
                        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                        (string) ($config['host'] ?? 'localhost'),
                        (string) ($config['port'] ?? '3306'),
                        (string) ($config['database'] ?? ''),
                        (string) ($config['charset'] ?? 'utf8mb4')
                    );
                    self::$connection = new PDO($dsn, (string) ($config['username'] ?? ''), (string) ($config['password'] ?? ''), $options);
                    break;
                case 'pgsql':
                    $dsn = sprintf(
                        'pgsql:host=%s;port=%s;dbname=%s',
                        (string) ($config['host'] ?? 'localhost'),
                        (string) ($config['port'] ?? '5432'),
                        (string) ($config['database'] ?? '')
                    );
                    self::$connection = new PDO($dsn, (string) ($config['username'] ?? ''), (string) ($config['password'] ?? ''), $options);
                    break;
                case 'sqlite':
                    $dsn = sprintf('sqlite:%s', (string) ($config['database'] ?? base_path('var/database.sqlite')));
                    self::$connection = new PDO($dsn, null, null, $options);
                    break;
                default:
                    throw new \InvalidArgumentException('Unsupported database driver: ' . $driver);
            }
        } catch (PDOException $e) {
            throw new \RuntimeException('Failed to connect to database: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        return self::$connection;
    }

    public static function disconnect(): void
    {
        self::$connection = null;
    }
}
