<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;
use App\Course\Domain\Repository\UserRepository;
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

    public function __invoke(string $username, string $password)
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
