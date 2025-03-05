<?php

namespace Api\Controllers;

use Api\Handlers\Http\Request\RequestHandler;
use Api\Handlers\Security\TokenVerifyHandler;
use Api\Interfaces\Controller\ControllerInterface;
use Api\Managers\MethodManager;
use Api\Middlewares\Http\Request\RequestMiddleware;
use Api\Middlewares\Security\AuthenticationMiddleware;
use Api\Middlewares\Security\AuthorizationMiddleware;
use Api\Modules\UserModule;
use Api\Services\Http\Request\RequestFilter;
use Api\Services\Http\Response\MethodResponse;
use Api\Services\Http\Response\Response;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Request\RouteRequest;
use Api\Services\Validation\Request\RequestValidator;
use Api\Services\Validation\Request\ValidationRules;

final class MethodController implements ControllerInterface
{
    public function handle(): void
    {
        $path_params = RouteRequest::getInstance()->getPathParams();

        $token_verify = TokenVerifyHandler::getInstance();

        $middleware = new AuthenticationMiddleware($token_verify);
        $middleware->check();

        $action = RouteConfig::getInstance()->getMethodAction(
            $path_params['group'],
            $path_params['method'],
            $path_params['action']
        );

        $user_module = UserModule::getInstance();
        $middleware = new AuthorizationMiddleware(
            $user_module,
            $token_verify,
            $action['no_auth'],
            $action['access']
        );
        $middleware->check();

        $request_params = (new RequestHandler())->handle();

        $validation_rules = new ValidationRules($request_params);
        $request_validator = new RequestValidator($validation_rules);

        $method_manager = new MethodManager(
            $action['version'],
            $path_params['group'],
            $path_params['method'],
            $path_params['action']
        );
        $method_manager->getValidation($request_validator->getValidationRules())->main();
        $request_validator->validate();

        $middleware = new RequestMiddleware($request_validator->isSuccess(), $request_validator->getErrors());
        $middleware->check();

        $request_params += $request_validator->getParams();
        $rule_fields = $request_validator->getValidationRules()->getFields();
        $filtered_params = RequestFilter::params($request_params, $rule_fields);

        $method_response = new MethodResponse();
        $method_manager->getMethod($filtered_params, $method_response)->main();

        $response = Response::getInstance();
        $response->setMethod(
            $method_response->getData(),
            $action['version'],
            $action['deprecated']
        );
    }
}