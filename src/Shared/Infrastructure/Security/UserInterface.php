<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UserInterface extends PasswordAuthenticatedUserInterface, SymfonyUserInterface
{
}
