<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\User;
use App\Shared\Domain\ValueObject\Password;

interface PasswordRepository
{
    public function create(User $user, string $plainPassword): Password;
}
