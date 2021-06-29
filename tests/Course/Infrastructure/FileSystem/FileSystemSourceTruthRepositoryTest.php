<?php

declare(strict_types=1);

namespace App\Tests\Course\Infrastructure\FileSystem;

use App\Course\Domain\DTO\Course;
use App\Course\Infrastructure\FileSystem\FileSystemSourceTruthRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Lambdish\Phunctional\first;

class FileSystemSourceTruthRepositoryTest extends KernelTestCase
{
    private string $pathFile;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->pathFile = $kernel->getContainer()
            ->getParameter('sourceTruth.path');
    }

    public function testValidValues()
    {
        $sourceTruthRepository = new FileSystemSourceTruthRepository($this->pathFile);
        $courses = $sourceTruthRepository->load();

        $this->assertEquals(count($courses->courses()), 5);

        /** @var Course $firstCourse */
        $firstCourse = first($courses->courses());
        $this->assertEquals($firstCourse->code(), 'Course A');
        $this->assertEquals($firstCourse->description(), 'Description A');
        $this->assertEquals($firstCourse->category(), 'CAT1');
        $this->assertEquals($firstCourse->level(), 'LEV1');
    }
}
