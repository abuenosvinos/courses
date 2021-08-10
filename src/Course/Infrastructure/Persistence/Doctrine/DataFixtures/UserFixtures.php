<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Admin\Domain\Entity\Admin;
use App\Shared\Domain\Entity\User;
use App\Shared\Domain\ValueObject\EmailAddress;
use App\Shared\Domain\ValueObject\UserId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = Admin::create(UserId::random(), EmailAddress::create('abuenosvinos@courses.com'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'abuenosvinosPass'));
        $manager->persist($user);

        $user = User::create(UserId::random(), EmailAddress::create('manolo@courses.com'));
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'manoloPass'));
        $manager->persist($user);

        $manager->flush();
    }
}
