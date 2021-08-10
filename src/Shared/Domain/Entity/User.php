<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\EmailAddress;
use App\Shared\Domain\ValueObject\UserId;
use App\Shared\Infrastructure\Security\UserInterface;

class User extends AggregateRoot implements UserInterface
{
    private UserId $id;
    protected EmailAddress $username;
    protected string $password;
    protected array $roles = [];

    private function __construct(UserId $id, EmailAddress $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function username(): EmailAddress
    {
        return $this->username;
    }

    public function password(): ?string
    {
        return $this->getPassword();
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username->value();
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @see UserInterface
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->username->value();
    }

    public static function create(UserId $id, EmailAddress $username = null): static
    {
        return new static($id, $username);
    }
}
