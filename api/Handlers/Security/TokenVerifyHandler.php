<?php

namespace Api\Handlers\Security;

use Api\Configs\VKApiConfig;
use Api\Services\Http\Request\Request;
use RuntimeException;

final class TokenVerifyHandler
{
    private static ?TokenVerifyHandler $instance = null;
    /**
     * @var array<string, mixed>
     */
    private array $sign_params = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws RuntimeException
     */
    public function __wakeup()
    {
        throw new RuntimeException();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function vkSignatureHandle(): void
    {
        $headers = Request::getAllHeaders();
        $authorization_header = (string)($headers['Authorization'] ?? '');

        if ($authorization_header !== '' && strpos($authorization_header, 'VK ') === 0) {
            $auth_params = substr($authorization_header, 3);
            $parse_url = parse_url($auth_params, PHP_URL_QUERY);

            if (!is_string($parse_url)) {
                return;
            }

            parse_str($parse_url, $query_params);

            if (!isset($query_params['sign'])) {
                return;
            }

            $sign_params = [];

            foreach ($query_params as $name => $value) {
                if (is_string($name)) {
                    if (strpos($name, 'vk_') !== 0) {
                        continue;
                    }

                    $sign_params[$name] = $value;
                }
            }

            if (isset($sign_params['vk_user_id'])) {
                ksort($sign_params);
                $sign_params_query = http_build_query($sign_params);
                $sign = rtrim(
                    strtr(
                        base64_encode(hash_hmac('sha256', $sign_params_query, VKApiConfig::getClientSecret(), true)),
                        '+/',
                        '-_'
                    ),
                    '='
                );

                if ($sign === $query_params['sign']) {
                    $sign_params['vk_user_id'] = (int)$sign_params['vk_user_id'];

                    $this->sign_params = $sign_params;
                }
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function getSignParams(): array
    {
        return $this->sign_params;
    }
}