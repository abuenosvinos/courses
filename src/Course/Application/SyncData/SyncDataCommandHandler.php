<?php

declare(strict_types=1);

namespace App\Course\Application\SyncData;

use App\Shared\Domain\Bus\Command\CommandHandler;

final class SyncDataCommandHandler implements CommandHandler
{
    private SyncData $syncData;

    public function __construct(SyncData $syncData)
    {
        $this->syncData = $syncData;
    }

    public function __invoke(SyncDataCommand $command): void
    {
        $courses = $command->courses();

        $this->syncData->__invoke($courses);
    }
}
