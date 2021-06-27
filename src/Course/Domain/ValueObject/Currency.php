<?php

declare(strict_types=1);

namespace App\Course\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Enum;
use InvalidArgumentException;

class Currency extends Enum
{
    public const EUR = 'EUR';
    public const USD = 'USD';

    protected function throwExceptionForInvalidValue($value)
    {
        throw new InvalidArgumentException(sprintf('It\'s not a valid code for a Price (%s)', $value));
    }
}
