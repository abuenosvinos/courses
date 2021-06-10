<?php

declare(strict_types = 1);

namespace App\Tests\Shared\Domain;

final class IntegerMother
{
    public static function random(): int
    {
        return MotherCreator::random()->randomNumber();
    }
}
