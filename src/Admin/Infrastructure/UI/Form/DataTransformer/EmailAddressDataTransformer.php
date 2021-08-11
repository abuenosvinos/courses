<?php

namespace App\Admin\Infrastructure\UI\Form\DataTransformer;

use App\Shared\Domain\ValueObject\EmailAddress;
use Symfony\Component\Form\DataTransformerInterface;

class EmailAddressDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        return isset($value) ? EmailAddress::create($value) : null;
    }
}
