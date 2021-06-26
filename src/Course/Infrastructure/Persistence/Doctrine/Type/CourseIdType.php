<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\Type;

use App\Course\Domain\Entity\CourseId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class CourseIdType extends Type
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new CourseId($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'VARCHAR(36)';
    }

    public function getName()
    {
        return CourseId::class;
    }
}
