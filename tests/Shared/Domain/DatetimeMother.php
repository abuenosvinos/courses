<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use DateTime;

final class DatetimeMother
{
    public static function random(): Datetime
    {
        return MotherCreator::random()->dateTime;
    }
}
