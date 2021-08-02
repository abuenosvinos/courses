<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\CourseChapter;
use App\Course\Domain\Entity\CourseSection;
use App\Shared\Application\Transformer\DataTransformer;

class CourseChaptersTransformer implements DataTransformer
{
    private CourseSection $courseSection;

    public function write(mixed $input)
    {
        $this->courseSection = $input;
    }

    public function read(): mixed
    {
        $sections = [];
        /** @var CourseChapter $chapter */
        foreach ($this->courseSection->chapters() as $chapter) {
            $dataChapter = [
                'title' => $chapter->title(),
                'description' => $chapter->description(),
                'duration' => $chapter->duration()
            ];
            $resource = $chapter->resource();
            if ($resource) {
                $dataChapter['resource'] = $resource->toArray();
            }
            $sections[] = $dataChapter;
        }
        return $sections;
    }
}
