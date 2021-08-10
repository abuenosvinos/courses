<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;

class EmailAddress extends StringValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($value);

        parent::__construct($value);
    }

    private function ensureIsValid(string $url): void
    {
        if (false === filter_var($url, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('The email <%s> is not well formatted', $url));
        }
    }
}
