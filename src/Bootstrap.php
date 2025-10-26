<?php

namespace Tamicktom\Lockbox;

use Dotenv\Dotenv;
use Tamicktom\Lockbox\Core\Config;

class Bootstrap
{
    public static function init(): void
    {
        // Load environment variables
        if (file_exists(base_path('.env'))) {
            $dotenv = Dotenv::createImmutable(base_path());
            $dotenv->safeLoad();
        }

        // Configure error reporting
        $appEnv = env('APP_ENV', 'production');
        $appDebug = filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN);

        if ($appEnv !== 'production' || $appDebug === true) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
        }

        // Timezone
        $APP_TIMEZONE = env('APP_TIMEZONE', 'UTC'); //* Timezone from environment variable
        $TIMEZONE = timezone_identifiers_list(); //* All available timezones
        if (!in_array($APP_TIMEZONE, $TIMEZONE)) {
            $APP_TIMEZONE = 'UTC'; //* Default timezone if not found
        }
        $timezoneId = array_search($APP_TIMEZONE, $TIMEZONE); //* Timezone ID from the environment variable
        if ($timezoneId === false) {
            $timezoneId = 'UTC'; //* Default timezone if not found
        }
        date_default_timezone_set((string) $timezoneId);

        // Load configuration files
        Config::loadAll(config_path());
    }
}
