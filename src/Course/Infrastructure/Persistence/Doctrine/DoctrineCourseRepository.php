<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Repository\CourseRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class DoctrineCourseRepository extends DoctrineRepository implements CourseRepository
{
    public function save(Course $course): void
    {
        $this->persist($course);
    }

    public function delete(Course $course): void
    {
        $this->remove($course);
    }

    public function find(string $code): ?Course
    {
        return $this->repository(Course::class)->find($code);
    }

    public function findByCriteria(SearchParams $searchParams): Paginator
    {
        $limit = $searchParams->limit();
        $page = $searchParams->page();

        $query = $this->repository(Course::class)->createQueryBuilder('c');

        if ($searchParams->category()) {
            $query = $query->andWhere('c.category = :category')->setParameter('category', $searchParams->category());
        }

        if ($searchParams->level()) {
            $query = $query->andWhere('c.level = :level')->setParameter('level', $searchParams->level());
        }

        if ($searchParams->priceMin() && $searchParams->priceMax()) {
            $query = $query->andWhere('(c.price >= :priceMin AND c.price <= :priceMax)')
                ->setParameter('priceMin', $searchParams->priceMin())
                ->setParameter('priceMax', $searchParams->priceMax());
        }

        if ($searchParams->orderBy()) {
            $query = $query->orderBy('c.' . $searchParams->orderBy()->value());
        }

        $query = $query
            ->getQuery()->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return new Paginator($query);
    }

    public function searchAll(): array
    {
        return $this->repository(Course::class)->findAll();
    }
}
