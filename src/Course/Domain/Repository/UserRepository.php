<?php

declare(strict_types = 1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\Entity\User;

interface UserRepository
{
    public function save(User $user): void;

    public function find(string $username): ?User;
}