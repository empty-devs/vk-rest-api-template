<?php

namespace Api\Middlewares\Security;

use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Handlers\Security\TokenVerifyHandler;
use Api\Interfaces\Middleware\MiddlewareInterface;

final class AuthenticationMiddleware implements MiddlewareInterface
{
    private TokenVerifyHandler $token_verify;

    public function __construct(TokenVerifyHandler $token_verify)
    {
        $this->token_verify = $token_verify;
    }

    public function check(): void
    {
        $this->token_verify->vkSignatureHandle();
        $sign_params = $this->token_verify->getSignParams();

        if (!isset($sign_params['vk_user_id'])) {
            throw new ApiException(
                'UNAUTHENTICATED',
                'Signature failed verification.',
                RequestConstant::CODE_UNAUTHORIZED
            );
        }
    }
}