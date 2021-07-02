<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Shared\Domain\Bus\Command\Command;

final class AddUserCommand extends Command
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        parent::__construct();

        $this->username = $username;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
