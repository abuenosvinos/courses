<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\Uuid;

final class AddUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(string $username)
    {
        $user = User::create(
            Uuid::random()->value(),
            $username
        );
        $user->setRoles(['ROLE_USER']);
        $this->userRepository->save($user);
    }
}
