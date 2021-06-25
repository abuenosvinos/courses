<?php

declare(strict_types=1);

namespace App\Course\Domain\Repository;

interface PricesRepository
{
    public function validCodes(): array;

    public function get(): int;
}
