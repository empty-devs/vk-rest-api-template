<?php

namespace Api\Methods\main\user\add\v1;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Handlers\Security\TokenVerifyHandler;
use Api\Interfaces\Method\Shared\BaseMethod;
use Api\Models\Database\tables\UserTable;
use Api\Modules\UserModule;
use Api\Modules\VKApiModule;

final class Method extends BaseMethod
{
    /**
     * @throws ApiException
     */
    public function main(): void
    {
        $user_module = UserModule::getInstance();
        $user_data = $user_module->getData();

        if (!isset($user_data['id'])) {
            $sign_params = TokenVerifyHandler::getInstance()->getSignParams();

            $get_user = VKApiModule::getInstance()->getUsers(
                (string)$sign_params['vk_user_id'],
                ['fields' => 'photo_100,sex', 'lang' => 'ru']
            );

            $this->validateVKUser($get_user['response']);
            $this->addUserToDatabase($sign_params, $get_user['response']);
        } else {
            $this->response->setData($user_data);
        }
    }

    /**
     * @param array<string, mixed>[] $get_user
     * @return void
     * @throws ApiException
     */
    private function validateVKUser(array $get_user): void
    {
        if (!isset($get_user[0]['first_name'], $get_user[0]['last_name'], $get_user[0]['photo_100'], $get_user[0]['sex'])) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_METHOD_INFO,
                'Failed to get user information.',
                RequestConstant::CODE_NOT_FOUND
            );
        }
    }

    /**
     * @param array<string, mixed> $sign_params
     * @param array<string, mixed>[] $get_user
     * @return void
     * @throws ApiException
     */
    private function addUserToDatabase(array $sign_params, array $get_user): void
    {
        $user_table = new UserTable();

        $success = $user_table->add(
            'user_id,first_name,last_name,photo,sex,joined',
            '?,?,?,?,?,?',
            [
                $sign_params['vk_user_id'],
                $get_user[0]['first_name'],
                $get_user[0]['last_name'],
                $get_user[0]['photo_100'],
                $get_user[0]['sex'],
                time()
            ]
        );

        if ($success === 0) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_METHOD_INFO,
                'Failed to add user.',
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }

        $this->response->setData($user_table->getUserByUserId($sign_params['vk_user_id']));
    }
}