<?php

namespace Api\Configs;

use Api\Interfaces\Config\Shared\BaseConfig;

final class SystemConfig extends BaseConfig
{
    public static function isMaintenanceMode(): bool
    {
        return self::getEnvVar('SYSTEM_MAINTENANCE_MODE', '0') === '1';
    }
}