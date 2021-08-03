<?php

declare(strict_types=1);

namespace App\Course\Application\ControlCourses;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Event\CourseDeleted;
use App\Shared\Domain\Bus\Event\EventHandler;
use Psr\Log\LoggerInterface;

class CourseDeletedEventHandler implements EventHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CourseDeleted $courseDeleted)
    {
        /** @var Course $course */
        $course = $courseDeleted->data()['course'];
        $this->logger->info(
            sprintf('Course delete %s', $course->code())
        );
    }
}
