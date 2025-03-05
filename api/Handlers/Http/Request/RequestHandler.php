<?php

namespace Api\Handlers\Http\Request;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Handlers\Http\Request\body\BodyRequestHandle;
use Api\Handlers\Http\Request\queryParams\QueryParamsRequestHandle;
use Api\Services\Http\Request\Request;

final class RequestHandler
{
    /**
     * @return array<string, mixed>
     * @throws ApiException
     */
    public function handle(): array
    {
        $http_method = Request::getHttpMethod();

        if (in_array($http_method, RequestConstant::METHODS_FOR_QUERY_PARAMS, true)) {
            return (new QueryParamsRequestHandle())->handle();
        }

        if (in_array($http_method, RequestConstant::METHODS_FOR_BODY, true)) {
            return (new BodyRequestHandle())->handle();
        }

        throw new ApiException(
            ApiExceptionConstant::TYPE_BAD_REQUEST_DATA,
            'Failed to process request data.',
            RequestConstant::CODE_BAD_REQUEST
        );
    }
}