<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Shared\Domain\ValueObject\Uuid;

final class UuidMother
{
    public static function random(): Uuid
    {
        return Uuid::random();
    }
}
