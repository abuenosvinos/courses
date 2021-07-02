<?php

declare(strict_types=1);

namespace App\Course\Application\AddUser;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class AddUserCommandHandler implements CommandHandler
{
    private AddUser $addUser;

    public function __construct(AddUser $addUser)
    {
        $this->addUser = $addUser;
    }

    public function __invoke(AddUserCommand $command)
    {
        $this->addUser->__invoke(
            $command->username(),
            $command->password()
        );
    }
}
