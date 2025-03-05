<?php

namespace Api\Configs;

use Api\Interfaces\Config\Shared\BaseConfig;

final class DataBaseConfig extends BaseConfig
{
    public static function getHost(): string
    {
        return self::getEnvVar('DATABASE_HOST', 'localhost');
    }

    public static function getUsername(): string
    {
        return self::getEnvVar('DATABASE_USERNAME');
    }

    public static function getPassword(): string
    {
        return self::getEnvVar('DATABASE_PASSWORD');
    }

    public static function getName(): string
    {
        return self::getEnvVar('DATABASE_NAME');
    }
}