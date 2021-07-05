<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\Type;

use App\Course\Domain\Entity\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UserIdType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserId
    {
        return UserId::create($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(36)';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return 'user_id';
    }
}
