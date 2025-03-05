<?php

namespace Api\Interfaces\Method;

use Api\Services\Validation\Request\ValidationRules;

interface ApiValidationInterface
{
    public function __construct(ValidationRules $rules);

    public function main(): void;
}