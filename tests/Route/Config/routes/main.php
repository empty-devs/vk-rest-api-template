<?php

use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Managers\RouteManager;

RouteManager::addMethod('test', static function (ActionsRouteConfigInterface $actions_config): void {
    $actions_config->GET('start', 1)->setInactive();
});