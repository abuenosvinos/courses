<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

use App\Course\Domain\DTO\Courses;

interface SourceTruthRepository
{
    public function load(): Courses;
}
