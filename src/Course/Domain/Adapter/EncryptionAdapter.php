<?php

declare(strict_types=1);

namespace App\Course\Domain\Adapter;

interface EncryptionAdapter
{
    public function encrypt(string $payload): string;

    public function decrypt(string $token): array;
}
