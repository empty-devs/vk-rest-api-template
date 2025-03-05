<?php

namespace Api\Constants\Exception;

interface ApiExceptionConstant
{
    public const TYPE_INTERNAL_DATABASE = 'INTERNAL_DATABASE';
    public const TYPE_UNAUTHORIZED = 'UNAUTHORIZED';
    public const TYPE_USER_BLOCKING = 'USER_BLOCKING';
    public const TYPE_METHOD_FORBIDDEN = 'METHOD_FORBIDDEN';
    public const TYPE_METHOD_NOT_FOUND = 'METHOD_NOT_FOUND';
    public const TYPE_METHOD_DISABLED = 'METHOD_DISABLED';
    public const TYPE_METHOD_INFO = 'METHOD_INFO';
    public const TYPE_HTTP_METHOD_NOT_ALLOWED = 'HTTP_METHOD_NOT_ALLOWED';
    public const TYPE_UNSUPPORTED_MEDIA_TYPE = 'UNSUPPORTED_MEDIA_TYPE';
    public const TYPE_BAD_REQUEST_DATA = 'BAD_REQUEST_DATA';
}