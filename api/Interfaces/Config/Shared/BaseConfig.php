<?php

namespace Api\Interfaces\Config\Shared;

use RuntimeException;

abstract class BaseConfig
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws RuntimeException
     */
    public function __wakeup()
    {
        throw new RuntimeException();
    }

    protected static function getEnvVar(string $key, string $default = null): string
    {
        $value = $_ENV[$key] ?? $default;

        if ($value === null) {
            throw new RuntimeException('Missing required environment variable: '.$key);
        }

        return $value;
    }
}
