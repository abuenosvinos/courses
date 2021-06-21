<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Repository\UserRepository;

final class AddUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(string $username)
    {
        $user = new User();
        $user->setUsername($username);
        $this->userRepository->save($user);
    }
}
