<?php

namespace Api\Constants\Validation;

interface ValidationRuleConstant
{
    public const TYPE_REQUIRED = 'REQUIRED';
    public const TYPE_FLOAT = 'FLOAT';
    public const TYPE_NUMBER = 'NUMBER';
    public const TYPE_INTEGER = 'INTEGER';
    public const TYPE_BOOLEAN = 'BOOLEAN';
    public const TYPE_STRING = 'STRING';
    public const TYPE_FILE = 'FILE';
    public const TYPE_IN = 'IN';
    public const TYPE_MIME = 'MIME';
    public const TYPE_MIN = 'MIN';
    public const TYPE_MAX = 'MAX';
    public const TYPE_REGEX = 'REGEX';
}