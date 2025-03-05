<?php

namespace Api\Modules;

use Api\Configs\VKApiConfig;
use JsonException;
use RuntimeException;

final class VKApiModule
{
    private static ?VKApiModule $instance = null;

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

    /**
     * @param string $user_ids
     * @param array<string, mixed> $params
     * @return array{response: mixed}
     */
    public function getUsers(string $user_ids, array $params = []): array
    {
        return $this->request('users.get', ['user_ids' => $user_ids] + $params);
    }

    /**
     * @param string $method
     * @param array<string, mixed> $params
     * @return array{response: mixed}
     */
    private function request(string $method, array $params = []): array
    {
        $params['v'] = VKApiConfig::getVersion();

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.vk.com/method/'.$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FORBID_REUSE => false,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 240,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.VKApiConfig::getServiceKey()
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
        ]);

        $response = curl_exec($ch);

        try {
            if (is_string($response)) {
                $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
            } else {
                $response = [];
            }
        } catch (JsonException $e) {
            $response = [];
        }
        curl_close($ch);

        if (isset($response['error'])) {
            return ['response' => []];
        }

        return ['response' => $response['response'] ?? []];
    }
}