<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;
use App\Course\Domain\Repository\UserRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function findById(UserId $id): ?User
    {
        return $this->repository(User::class)->find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->repository(User::class)->findOneBy(['username' => $username]);
    }
}
