<?php

declare(strict_types=1);

namespace App\Course\Application\GetTokenUser;

use App\Course\Domain\Repository\UserRepository;
use App\Course\Infrastructure\JWT\Encrypt;

final class GetTokenUser
{
    private UserRepository $userRepository;
    private Encrypt $encrypt;

    public function __construct(UserRepository $userRepository, Encrypt $encrypt)
    {
        $this->userRepository = $userRepository;
        $this->encrypt = $encrypt;
    }

    public function __invoke(string $username): ?string
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user) {
            return $this->encrypt->encrypt(json_encode([
                'username' => $user->getUsername()
            ]));
        }

        return null;
    }
}
