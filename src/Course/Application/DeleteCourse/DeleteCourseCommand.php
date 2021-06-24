<?php

declare(strict_types=1);

namespace App\Course\Application\DeleteCourse;

use App\Shared\Domain\Bus\Command\Command;

final class DeleteCourseCommand extends Command
{
    private string $code;

    public function __construct(string $code)
    {
        parent::__construct();

        $this->code = $code;
    }

    public function code(): string
    {
        return $this->code;
    }
}
