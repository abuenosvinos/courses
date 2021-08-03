<?php

declare(strict_types=1);

namespace App\Course\Application\ControlCourses;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseModified;
use App\Shared\Domain\Bus\Event\EventHandler;
use Psr\Log\LoggerInterface;

class CourseModifiedEventHandler implements EventHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CourseModified $courseModified)
    {
        /** @var Course $course */
        $course = $courseModified->data()['course'];
        $this->logger->info(
            sprintf('Course modified %s', $course->code())
        );
    }
}
