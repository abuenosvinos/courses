<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger\Command;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Command\CommandNotRegisteredError;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyCommandBus implements CommandBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->bus = $commandBus;
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($command);
        }
    }
}
