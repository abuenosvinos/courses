<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AddUser
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function __invoke(string $username, string $password): void
    {
        $user = User::create(
            UserId::random(),
            $username,
        );
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
        $user->setRoles(['ROLE_USER']);
        $this->userRepository->save($user);
    }
}
