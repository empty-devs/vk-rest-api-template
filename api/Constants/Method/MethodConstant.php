<?php

namespace Api\Constants\Method;

interface MethodConstant
{
    public const NAMESPACE = 'Api\\Methods';
    public const V1 = 1;
    public const V2 = 2;
    public const AVAILABLE_VERSIONS = [self::V1, self::V2];
}