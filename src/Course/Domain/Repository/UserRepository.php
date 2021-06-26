<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByUsername(string $username): ?User;
}
