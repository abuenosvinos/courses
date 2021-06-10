<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\FileSystem;

use App\Course\Domain\DTO\Course;
use App\Course\Domain\DTO\Courses;
use App\Course\Domain\Repository\SourceTruthRepository;

class FileSystemSourceTruthRepository implements SourceTruthRepository
{
    private string $pathFile;

    public function __construct(string $pathFile)
    {
        $this->pathFile = $pathFile;
    }

    public function load(): Courses
    {
        $courses = new Courses();
        if (($fp = fopen($this->pathFile, "r")) !== FALSE) {
            $row = 1;
            while (($data = fgetcsv($fp, 1000, "\t")) !== FALSE) {
                if ($row++ == 1) continue;

                $courses->addCourse(new Course(
                    $data[0],
                    $data[1],
                    $data[2],
                    $data[3],
                ));
            }
            fclose($fp);
        }
        return $courses;
    }
}