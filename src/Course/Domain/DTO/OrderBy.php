<?php

declare(strict_types = 1);

namespace App\Course\Domain\DTO;

use App\Shared\Domain\ValueObject\Enum;

final class OrderBy extends Enum
{
    const CATEGORY = 'category';
    const LEVEL = 'level';
    const PRICE = 'price';

    protected function throwExceptionForInvalidValue($value)
    {
        throw new \Exception('El valor introducido no es válido');
    }
}