<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Repository\PasswordRepository;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\EmailAddress;
use App\Shared\Domain\ValueObject\UserId;

final class AddUser
{
    private UserRepository $userRepository;
    private PasswordRepository $passwordRepository;

    public function __construct(UserRepository $userRepository, PasswordRepository $passwordRepository)
    {
        $this->userRepository = $userRepository;
        $this->passwordRepository = $passwordRepository;
    }

    public function __invoke(string $username, string $password): void
    {
        $user = User::create(
            UserId::random(),
            EmailAddress::create($username),
        );

        $user->setPassword($this->passwordRepository->create($user, $password));
        $user->setRoles(['ROLE_USER']);
        $this->userRepository->save($user);
    }
}
