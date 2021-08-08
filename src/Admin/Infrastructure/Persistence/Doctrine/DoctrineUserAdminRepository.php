<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Persistence\Doctrine;

use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Repository\UserAdminRepository;
use App\Shared\Application\Paginator;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use ArrayIterator;

final class DoctrineUserAdminRepository extends DoctrineRepository implements UserAdminRepository
{
    public function search(Criteria $criteria): Paginator
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        $results = $this->repository(Admin::class)->matching($doctrineCriteria);
        $total = $results->count();

        return new Paginator(
            new ArrayIterator($results->toArray()),
            $total,
            $criteria->offset(),
            $criteria->limit()
        );
    }
}
