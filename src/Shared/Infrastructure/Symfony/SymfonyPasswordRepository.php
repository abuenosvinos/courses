<?php

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Repository\PasswordRepository;
use App\Shared\Domain\ValueObject\Password;
use App\Shared\Domain\ValueObject\PlainPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SymfonyPasswordRepository implements PasswordRepository
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function create(User $user, string $plainPassword): Password
    {
        return Password::create($this->userPasswordHasher->hashPassword($user, PlainPassword::create($plainPassword)));
    }
}
