<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine;

use App\Course\Domain\DTO\SearchParams;
use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseId;
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

    public function findById(CourseId $id): ?Course
    {
        /** @var Course $course */
        $course = $this->repository(Course::class)->find($id);

        return $course;
    }

    public function findBySlug(string $slug): ?Course
    {
        /** @var Course $course */
        $course = $this->repository(Course::class)->findOneBy(['slug' => $slug]);

        return $course;
    }

    public function findByCode(string $code): ?Course
    {
        /** @var Course $course */
        $course = $this->repository(Course::class)->findOneBy(['code' => $code]);

        return $course;
    }

    public function findByCriteria(SearchParams $searchParams): Paginator
    {
        $limit = $searchParams->limit();
        $page = $searchParams->page();

        $query = $this->repository(Course::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.prices', 'pri')
            ->leftJoin('c.categories', 'cat')
            ->leftJoin('c.level', 'lev');

        if ($searchParams->category()) {
            $query = $query->andWhere('cat.name = :category')->setParameter('category', $searchParams->category());
        }

        if ($searchParams->level()) {
            $query = $query->andWhere('lev.name = :level')->setParameter('level', $searchParams->level());
        }

        if ($searchParams->priceMin() && $searchParams->priceMax()) {
            $query = $query->andWhere('(pri.money.amount >= :priceMin AND pri.money.amount <= :priceMax)')
                ->setParameter('priceMin', $searchParams->priceMin())
                ->setParameter('priceMax', $searchParams->priceMax());
        }

        if ($searchParams->orderBy()) {
            $query = match ($searchParams->orderBy()->value()) {
                'category' => $query->orderBy('cat.name'),
                'price' => $query->orderBy('pri.money.amount'),
                default => $query->orderBy('c.' . $searchParams->orderBy()->value()),
            };
        }
        $query->addOrderBy('c.code');

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
