<?php

namespace App\Application;

use App\Domain\Interface\UserRepositoryInterface;
use App\Domain\Exception\RepositoryException;
use App\Domain\Exception\ServiceException;
use phpDocumentor\Reflection\Types\Boolean;

class CreateUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute(string $username, string $password): bool|string
    {
        try {
            $product = $this->userRepository->createUser($username, $password);

            return $product;
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }
}
