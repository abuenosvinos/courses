<?php

declare(strict_types=1);

namespace App\Course\Application\GetTokenUser;

use App\Course\Domain\Adapter\EncryptionAdapter;
use App\Shared\Domain\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class GetTokenUser
{
    private UserRepository $userRepository;
    private EncryptionAdapter $encryptionAdapter;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, EncryptionAdapter $encryptionAdapter, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->encryptionAdapter = $encryptionAdapter;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function __invoke(string $username, string $password): ?string
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user) {
            if ($this->userPasswordHasher->isPasswordValid($user, $password)) {
                return $this->encryptionAdapter->encrypt(json_encode([
                    'username' => $user->username()
                ]));
            }
        }

        return null;
    }
}
