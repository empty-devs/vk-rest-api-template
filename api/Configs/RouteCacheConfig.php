<?php

namespace Api\Configs;

use Api\Interfaces\Config\Shared\BaseConfig;

final class RouteCacheConfig extends BaseConfig
{
    public static function isCacheMode(): bool
    {
        return self::getEnvVar('ROUTE_CACHE_MODE', '0') === '1';
    }
}