<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Repository\CourseLevelRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineCourseLevelRepository extends DoctrineRepository implements CourseLevelRepository
{
    public function findByName(string $name): ?CourseLevel
    {
        /** @var CourseLevel $level */
        $level = $this->repository(CourseLevel::class)->findOneBy(['name' => $name]);

        return $level;
    }

    public function searchAll(): array
    {
        $query = $this->repository(CourseLevel::class)->createQueryBuilder('c')->getQuery();
        $query = $query->setCacheable(true)->setResultCacheId('CourseLevel||searchAll');

        return $query->execute();
    }
}
