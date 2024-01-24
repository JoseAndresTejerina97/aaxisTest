<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Exception\RepositoryException;
use App\Domain\Interface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private $validator;
    private $passwordHasher;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,UserPasswordHasherInterface $passwordHasher)
    {
        $this->validator = $validator;
        $this->passwordHasher=$passwordHasher;
        parent::__construct($registry, User::class);
    }

    /**
     * @throws RepositoryException
     */
    public function createUser(string $username, string $password): bool|string
    {
        $errorsLabels = "";
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);

        $this->getEntityManager()->persist($user);
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorsLabels = (string) $errors;
            return $errorsLabels;
        }
        try {
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $exception) {
            return new RepositoryException($exception->getMessage());
        }
    }
}
