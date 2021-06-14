<?php

declare(strict_types = 1);

namespace App\Course\Application\AddUser;

use App\Shared\Domain\Bus\Command\Command;

final class AddUserCommand extends Command
{
    private string $username;

    public function __construct(string $username)
    {
        parent::__construct();

        $this->username = $username;
    }

    public function username(): string
    {
        return $this->username;
    }
}
