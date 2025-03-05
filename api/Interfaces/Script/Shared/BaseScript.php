<?php

namespace Api\Interfaces\Script\Shared;

abstract class BaseScript
{
    public function __construct()
    {
        if (PHP_SAPI !== 'cli') {
            exit();
        }
    }

    abstract public function make(): void;
}