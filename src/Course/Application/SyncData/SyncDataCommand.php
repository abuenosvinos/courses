<?php

declare(strict_types=1);

namespace App\Course\Application\SyncData;

use App\Course\Domain\DTO\Courses;
use App\Shared\Domain\Bus\Command\Command;

final class SyncDataCommand extends Command
{
    private Courses $courses;

    public function __construct(Courses $courses)
    {
        parent::__construct();

        $this->courses = $courses;
    }

    public function courses(): Courses
    {
        return $this->courses;
    }
}
