<?php

use Api\Constants\Method\MethodConstant;
use Api\Constants\Method\methods\UserMethodConstant;
use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Managers\RouteManager;

RouteManager::addMethod(UserMethodConstant::METHOD, static function (ActionsRouteConfigInterface $actions_config): void {
    $actions_config->GET(UserMethodConstant::ACTION_ADD, MethodConstant::V1)->setNoAuth();
});