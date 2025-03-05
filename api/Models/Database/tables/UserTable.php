<?php

namespace Api\Models\Database\tables;

use Api\Exceptions\ApiException;
use Api\Models\Database\DatabaseModel;

final class UserTable extends DatabaseModel
{
    protected string $table_name = 'users';

    /**
     * @param int $user_id
     * @return array<string, mixed>
     * @throws ApiException
     */
    public function getUserByUserId(int $user_id): array
    {
        return $this->getWhere(
            'id,user_id,first_name,last_name,photo,sex,access,joined,blocking',
            'user_id = ?',
            [$user_id]
        )->fetch();
    }
}