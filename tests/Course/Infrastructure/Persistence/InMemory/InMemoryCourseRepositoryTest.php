<?php

declare(strict_types=1);

namespace App\Tests\Course\Infrastructure\Persistence\InMemory;

use App\Course\Infrastructure\Persistence\InMemory\InMemoryCourseRepository;
use App\Tests\Shared\Domain\CourseMother;
use PHPUnit\Framework\TestCase;

class InMemoryCourseRepositoryTest extends TestCase
{
    public function testValidValues()
    {
        $courseRepository = new InMemoryCourseRepository();

        $courseA = CourseMother::create();
        $courseRepository->save($courseA);
        $courseB = CourseMother::create();
        $courseRepository->save($courseB);

        $this->assertEquals(count($courseRepository->searchAll()), 2);
        $this->assertEquals($courseRepository->find($courseB->code()), $courseB);

        $courseRepository->delete($courseA);

        $this->assertEquals(count($courseRepository->searchAll()), 1);
        $this->assertEquals($courseRepository->find($courseA->code()), null);
    }
}