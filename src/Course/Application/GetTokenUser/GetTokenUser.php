<?php

declare(strict_types=1);

namespace App\Course\Application\GetTokenUser;

use App\Course\Domain\Adapter\EncryptionAdapter;
use App\Course\Domain\Repository\UserRepository;

final class GetTokenUser
{
    private UserRepository $userRepository;
    private EncryptionAdapter $encryptionAdapter;

    public function __construct(UserRepository $userRepository, EncryptionAdapter $encryptionAdapter)
    {
        $this->userRepository = $userRepository;
        $this->encryptionAdapter = $encryptionAdapter;
    }

    public function __invoke(string $username): ?string
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user) {
            return $this->encryptionAdapter->encrypt(json_encode([
                'username' => $user->getUsername()
            ]));
        }

        return null;
    }
}
