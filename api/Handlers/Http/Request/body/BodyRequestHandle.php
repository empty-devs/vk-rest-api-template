<?php

namespace Api\Handlers\Http\Request\body;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Services\Http\Request\Request;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Request\RouteRequest;

final class BodyRequestHandle
{
    /**
     * @return array<string, mixed>
     * @throws ApiException
     */
    public function handle(): array
    {
        $content_type = Request::getContentType();

        $path_params = RouteRequest::getInstance()->getPathParams();
        $action = RouteConfig::getInstance()->getMethodAction(
            $path_params['group'],
            $path_params['method'],
            $path_params['action']
        );
        $wait_file = $action['wait_file'];

        if (!$wait_file && strpos($content_type, 'application/json') !== false) {
            return (new JsonRequestHandle())->handle();
        }

        if ($wait_file && strpos($content_type, 'multipart/form-data') !== false) {
            return (new MultipartRequestHandle())->handle();
        }

        throw new ApiException(
            ApiExceptionConstant::TYPE_UNSUPPORTED_MEDIA_TYPE,
            'Unsupported content type.',
            RequestConstant::CODE_UNSUPPORTED_MEDIA_TYPE
        );
    }
}