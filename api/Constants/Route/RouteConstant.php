<?php

namespace Api\Constants\Route;

interface RouteConstant
{
    public const GROUP_BASE = 'main';
    public const GROUP_ADMIN = 'admin';
    public const AVAILABLE_GROUPS = [self::GROUP_BASE, self::GROUP_ADMIN];
}