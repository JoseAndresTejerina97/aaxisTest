<?php

namespace App\Domain\Interface;

use App\Domain\Exception\RepositoryException;

interface UserRepositoryInterface
{
    /**
     * @throws RepositoryException
     */
    public function createUser(string $username,string $password): bool|string;

}
