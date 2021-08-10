<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Repository\UserRepository;
use App\Shared\Domain\ValueObject\UserId;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persistAndFlush($user);
    }

    public function remove(User $user): void
    {
        $this->removeAndFlush($user);
    }

    public function findById(UserId $id): ?User
    {
        /** @var User $user */
        $user = $this->repository(User::class)->find($id);

        return $user;
    }

    public function findByUsername(string $username): ?User
    {
        /** @var User $user */
        $user = $this->repository(User::class)->findOneBy(['username.value' => $username]);

        return $user;
    }
}
