<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = User::create(UserId::random(), 'abuenosvinos');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $user = User::create(UserId::random(), 'manolo');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
