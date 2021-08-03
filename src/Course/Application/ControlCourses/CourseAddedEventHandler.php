<?php

declare(strict_types=1);

namespace App\Course\Application\ControlCourses;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseAdded;
use App\Shared\Domain\Bus\Event\EventHandler;
use Psr\Log\LoggerInterface;

class CourseAddedEventHandler implements EventHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CourseAdded $courseAdded)
    {
        /** @var Course $course */
        $course = $courseAdded->data()['course'];
        $this->logger->info(
            sprintf('Course added %s', $course->code())
        );
    }
}
