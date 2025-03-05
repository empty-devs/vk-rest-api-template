<?php

namespace Api\Loaders;

use Dotenv\Dotenv;

final class ConfigLoader
{
    public function load(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();
    }
}