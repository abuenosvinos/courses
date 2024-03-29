<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Course\Domain\Entity\Course;
use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseChapter;
use App\Course\Domain\Entity\CourseId;
use App\Course\Domain\Entity\CourseLevel;
use App\Course\Domain\Entity\CourseSection;
use App\Course\Domain\Entity\Price;
use App\Course\Domain\Entity\Resource;
use App\Course\Domain\Entity\Resource\Audio;
use App\Course\Domain\Entity\Resource\Pdf;
use App\Course\Domain\Entity\Resource\Video;
use App\Course\Domain\ValueObject\Currency;
use App\Course\Domain\ValueObject\Money;
use App\Shared\Domain\Bus\Event\Event;
use App\Shared\Domain\Bus\Event\EventBus;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    private EventBus $eventBus;

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

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
                DateTime::createFromFormat('Y-m-d H:i:s', '2021-10-25 10:00:00'),
                $levelCourse,
                ...$categoriesCourse
            );

            for ($j = 1; $j <= 2; $j++) {
                $section = CourseSection::create(
                    'Título seccion ' . $j,
                    'Descripción seccion ' . $j,
                    $j
                );

                for ($k = 1; $k <= 2; $k++) {
                    $chapter = CourseChapter::create(
                        'Título capítulo ' . $k,
                        'Descripción capítulo ' . $k,
                        $k
                    );
                    $chapter->setDuration($i + $j + $k);
                    $chapter->setResource($this->createResource($i + $j + $k));

                    $section->addChapter($chapter);
                }

                $course->addSection($section);
            }

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

            $events = $course->pullDomainEvents();
            /** @var Event $event */
            foreach ($events as $event) {
                $this->eventBus->notify($event);
            }
        }

        $manager->flush();
    }

    public function createResource(int $index): Resource
    {
        switch ($index % 3) {
            case 0:
                return Video::create('url_video_' . $index);
            case 1:
                return Audio::create('url_audio_' . $index);
            case 2:
                return Pdf::create('path_pdf_' . $index, $index * 100);
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
