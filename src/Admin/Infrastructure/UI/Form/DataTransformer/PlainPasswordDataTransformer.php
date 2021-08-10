<?php

namespace App\Admin\Infrastructure\UI\Form\DataTransformer;

use App\Shared\Domain\ValueObject\PlainPassword;
use Symfony\Component\Form\DataTransformerInterface;

class PlainPasswordDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return isset($value) ? PlainPassword::create($value) : null;
    }

    public function reverseTransform($value)
    {
        return $value;
    }
}
