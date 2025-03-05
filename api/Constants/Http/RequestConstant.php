<?php

namespace Api\Constants\Http;

interface RequestConstant
{
    public const CODE_OK = 200;
    public const CODE_BAD_REQUEST = 400;
    public const CODE_UNAUTHORIZED = 401;
    public const CODE_FORBIDDEN = 403;
    public const CODE_NOT_FOUND = 404;
    public const CODE_METHOD_NOT_ALLOWED = 405;
    public const CODE_GONE = 410;
    public const CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    public const CODE_INTERNAL_SERVER_ERROR = 500;
    public const CODE_SERVICE_UNAVAILABLE = 503;
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_PUT = 'PUT';
    public const METHOD_HEAD = 'HEAD';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHODS_NOT_ALLOWED = [self::METHOD_HEAD, self::METHOD_OPTIONS];
    public const METHODS_FOR_QUERY_PARAMS = [self::METHOD_GET, self::METHOD_DELETE];
    public const METHODS_FOR_BODY = [self::METHOD_POST, self::METHOD_PATCH, self::METHOD_PUT];
}