<?php

namespace App\Shared\Application\Transformer\Course;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\Price;
use App\Shared\Application\Transformer\DataTransformer;

class CoursePricesTransformer implements DataTransformer
{
    private Course $course;

    public function write(mixed $input)
    {
        $this->course = $input;
    }

    public function read(): mixed
    {
        $prices = [];
        /** @var Price $price */
        foreach ($this->course->prices() as $price) {
            $prices[] = [
                'price' => $price->money()->amount(),
                'code' => $price->money()->currency()->value()
            ];
        }
        return $prices;
    }
}
