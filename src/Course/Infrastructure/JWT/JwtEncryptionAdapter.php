<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\JWT;

use App\Course\Domain\Adapter\EncryptionAdapter;

class JwtEncryptionAdapter implements EncryptionAdapter
{
    private Encrypt $encryptor;
    private Decrypt $decryptor;

    public function __construct(Encrypt $encryptor, Decrypt $decryptor)
    {
        $this->encryptor = $encryptor;
        $this->decryptor = $decryptor;
    }

    public function encrypt(string $payload): string
    {
        return $this->encryptor->encrypt($payload);
    }

    public function decrypt(string $token): array
    {
        return $this->decryptor->decrypt($token);
    }
}
