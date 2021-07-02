<?php

declare(strict_types=1);

namespace App\Course\Domain\Entity;

use App\Shared\Domain\Entity\User as SharedUser;

class User extends SharedUser
{
    private UserId $id;

    private function __construct(UserId $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->getUserIdentifier();
    }

    public function password(): ?string
    {
        return $this->getPassword();
    }

    public static function create(UserId $id, string $username): self
    {
        return new self($id, $username);
    }
}
