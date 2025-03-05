<?php

namespace Api\Handlers\Http\Request\body;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use JsonException;

final class JsonRequestHandle
{
    /**
     * @return array<string, mixed>
     * @throws ApiException
     */
    public function handle(): array
    {
        try {
            $data = file_get_contents('php://input');

            if ($data !== false && $data !== '') {
                $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

                if (is_array($data) && $data !== []) {
                    return $data;
                }

                throw new ApiException(
                    ApiExceptionConstant::TYPE_BAD_REQUEST_DATA,
                    'JSON must decode to an array.',
                    RequestConstant::CODE_BAD_REQUEST
                );
            }
        } catch (JsonException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_BAD_REQUEST_DATA,
                'Invalid JSON in request body.',
                RequestConstant::CODE_BAD_REQUEST
            );
        }

        throw new ApiException(
            ApiExceptionConstant::TYPE_BAD_REQUEST_DATA,
            'Empty request body.',
            RequestConstant::CODE_BAD_REQUEST
        );
    }
}