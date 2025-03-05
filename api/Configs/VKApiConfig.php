<?php

namespace Api\Configs;

use Api\Interfaces\Config\Shared\BaseConfig;

final class VKApiConfig extends BaseConfig
{
    public static function getClientSecret(): string
    {
        return self::getEnvVar('VK_API_CLIENT_SECRET');
    }

    public static function getServiceKey(): string
    {
        return self::getEnvVar('VK_API_SERVICE_KEY');
    }

    public static function getVersion(): string
    {
        return self::getEnvVar('VK_API_VERSION', '5.199');
    }
}