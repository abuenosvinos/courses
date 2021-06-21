<?php

declare(strict_types=1);

namespace App\Course\Domain\DTO;

use App\Shared\Domain\ValueObject\Enum;

final class OrderBy extends Enum
{
    public const CATEGORY = 'category';
    public const LEVEL = 'level';
    public const PRICE = 'price';

    protected function throwExceptionForInvalidValue($value)
    {
        throw new \Exception('El valor introducido no es válido');
    }
}
