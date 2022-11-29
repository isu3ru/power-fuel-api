<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $data): User
    {
        return User::create($data);
    }
}
