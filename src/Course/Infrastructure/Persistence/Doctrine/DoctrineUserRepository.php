<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Repository\UserRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function find(string $username): ?User
    {
        return $this->repository(User::class)->findOneBy(['username' => $username]);
    }
}
