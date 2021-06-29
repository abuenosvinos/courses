<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\Type;

use App\Course\Domain\Entity\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UserIdType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::create($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'VARCHAR(36)';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return 'user_id';
    }
}
