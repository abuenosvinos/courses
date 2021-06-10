<?php

declare(strict_types = 1);

namespace App\Course\Application\SyncData;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class SyncDataCommandHandler implements CommandHandler
{
    private SyncData $configurePlanet;

    public function __construct(SyncData $configurePlanet)
    {
        $this->configurePlanet = $configurePlanet;
    }

    public function __invoke(SyncDataCommand $command)
    {
        $courses = $command->courses();

        $this->configurePlanet->__invoke($courses);
    }
}
