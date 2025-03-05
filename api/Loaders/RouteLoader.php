<?php

namespace Api\Loaders;

final class RouteLoader
{
    public function load(string $group): void
    {
        require 'api/Routes/'.$group.'.php';
    }
}