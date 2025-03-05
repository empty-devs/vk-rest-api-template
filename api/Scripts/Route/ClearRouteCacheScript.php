<?php

namespace Api\Scripts\Route;

require_once 'vendor/autoload.php';

use Api\Constants\Route\RouteConstant;
use Api\Interfaces\Script\Shared\BaseScript;
use Throwable;

final class ClearRouteCacheScript extends BaseScript
{
    public function make(): void
    {
        $route_groups = RouteConstant::AVAILABLE_GROUPS;

        $cache_dir = __DIR__.'/../../../caches/routes';

        foreach ($route_groups as $group) {
            $file_path = $cache_dir.'/'.$group.'.json';

            if (file_exists($file_path)) {
                try {
                    if (unlink($file_path)) {
                        echo 'Successfully deleted route group cache: '.$group.PHP_EOL;
                    } else {
                        echo 'Failed to delete route group cache: '.$group.PHP_EOL;
                    }
                } catch (Throwable $e) {
                    echo 'Error deleting route cache for group '.$group.': '.$e->getMessage().PHP_EOL;
                }
            } else {
                echo 'Cache file not found for group: '.$group.PHP_EOL;
            }
        }
    }
}

(new ClearRouteCacheScript())->make();