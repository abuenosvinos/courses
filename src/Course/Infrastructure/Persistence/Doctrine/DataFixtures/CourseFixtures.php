<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseId;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Entity\Price;
use App\Course\Domain\ValueObject\Currency;
use App\Course\Domain\ValueObject\Money;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [];
        for ($i = 1; $i <= 3; $i++) {
            $category = CourseCategory::create('Categoría ' . $i);
            $categories[$i] = $category;
            $manager->persist($category);
        }

        $levels = [];
        for ($i = 1; $i <= 3; $i++) {
            $level = CourseLevel::create('Nivel ' . $i);
            $levels[$i] = $level;
            $manager->persist($level);
        }

        for ($i = 1; $i <= 20; $i++) {
            $levelCourse = $levels[1 + ($i % 3)];
            $categoriesCourse = [];
            for ($j = 1; $j <= ($i % 3); $j++) {
                $categoriesCourse[] = $categories[$j];
            }

            $course = Course::create(
                CourseId::random(),
                'Título de prueba ' . $i,
                'Descripción de prueba ' . $i,
                $levelCourse,
                ...$categoriesCourse
            );

            $j = 0;
            foreach (Currency::values() as $currency) {
                $course->addPrice(
                    Price::create(
                        Money::create(
                            ($i * 100) + ($j * 10),
                            Currency::create($currency)
                        )
                    )
                );
                $j++;
            }
            $manager->persist($course);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
