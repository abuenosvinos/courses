<?php

declare(strict_types=1);

namespace App\Course\Application\ControlCourses;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseAdded;
use App\Course\Domain\Event\CourseDeleted;
use App\Course\Domain\Event\CourseModified;
use App\Shared\Domain\Bus\Event\EventHandler;
use Psr\Log\LoggerInterface;

class ControlCoursesEventHandler implements EventHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function courseAdded(CourseAdded $courseAdded)
    {
        /** @var Course $course */
        $course = $courseAdded->data()['course'];
        $this->logger->info(
            sprintf('Course added %s', $course->code())
        );
    }

    public function courseModified(CourseModified $courseModified)
    {
        /** @var Course $course */
        $course = $courseModified->data()['course'];
        $this->logger->info(
            sprintf('Course modified %s', $course->code())
        );
    }

    public function courseDeleted(CourseDeleted $courseDeleted)
    {
        /** @var Course $course */
        $course = $courseDeleted->data()['course'];
        $this->logger->info(
            sprintf('Course delete %s', $course->code())
        );
    }

    public static function getHandledMessages(): iterable
    {
        yield CourseAdded::class => [
            'method' => 'courseAdded',
        ];
        yield CourseModified::class => [
            'method' => 'courseModified',
        ];
        yield CourseDeleted::class => [
            'method' => 'courseDeleted',
        ];
    }
}
