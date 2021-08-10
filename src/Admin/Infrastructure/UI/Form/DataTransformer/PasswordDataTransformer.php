<?php

namespace App\Admin\Infrastructure\UI\Form\DataTransformer;

use App\Shared\Domain\ValueObject\Password;
use Symfony\Component\Form\DataTransformerInterface;

class PasswordDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        return isset($value) ? Password::create($value) : null;
    }
}
