<?php

namespace Api\Middlewares\Security;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Handlers\Security\TokenVerifyHandler;
use Api\Interfaces\Middleware\MiddlewareInterface;
use Api\Modules\UserModule;

final class AuthorizationMiddleware implements MiddlewareInterface
{
    private UserModule $user_module;
    private TokenVerifyHandler $token_verify;
    private bool $no_auth;
    private int $access;

    /**
     * @param UserModule $user_module
     * @param TokenVerifyHandler $token_verify
     * @param bool $no_auth
     * @param int $access
     */
    public function __construct(UserModule $user_module, TokenVerifyHandler $token_verify, bool $no_auth, int $access)
    {
        $this->user_module = $user_module;
        $this->token_verify = $token_verify;
        $this->no_auth = $no_auth;
        $this->access = $access;
    }

    public function check(): void
    {
        $sign_params = $this->token_verify->getSignParams();
        $this->user_module->authorization($sign_params['vk_user_id']);

        if (!$this->no_auth) {
            if (!isset($this->user_module->getData()['id'])) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_UNAUTHORIZED,
                    'User does not exist.',
                    RequestConstant::CODE_UNAUTHORIZED
                );
            }

            if ($this->user_module->isBlocking()) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_USER_BLOCKING,
                    'Access to the service is blocked.',
                    RequestConstant::CODE_FORBIDDEN
                );
            }

            if (!$this->user_module->isAccess($this->access)) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_METHOD_FORBIDDEN,
                    'Access to the method is blocked.',
                    RequestConstant::CODE_FORBIDDEN
                );
            }
        }
    }
}