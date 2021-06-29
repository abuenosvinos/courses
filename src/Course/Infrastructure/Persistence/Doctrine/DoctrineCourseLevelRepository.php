<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Repository\CourseLevelRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCourseLevelRepository extends DoctrineRepository implements CourseLevelRepository
{
    public function findByName(string $name): ?CourseLevel
    {
        return $this->repository(CourseLevel::class)->findOneBy(['name' => $name]);
    }

    public function searchAll(): array
    {
        $query = $this->repository(CourseLevel::class)->createQueryBuilder('c')->getQuery();
        $query = $query->setCacheable(true)->setResultCacheId('CourseLevel||searchAll');

        return $query->execute();
    }
}
