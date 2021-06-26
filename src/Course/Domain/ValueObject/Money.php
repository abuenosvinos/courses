<?php

declare(strict_types=1);

namespace App\Course\Domain\ValueObject;

use InvalidArgumentException;

class Money
{
    private int $amount;
    private Currency $currency;

    private function __construct(int $amount, Currency $currency)
    {
        $this->validate($amount);

        $this->amount = $amount;
        $this->currency = $currency;
    }

    private function validate(int $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Price can\'t be negative');
        }
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public static function create(int $amount, Currency $currency): Money
    {
        return new self($amount, $currency);
    }
}
