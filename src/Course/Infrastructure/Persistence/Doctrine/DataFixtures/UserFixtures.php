<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Persistence\Doctrine\DataFixtures;

use App\Admin\Domain\Entity\Admin;
use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Repository\PasswordRepository;
use App\Shared\Domain\ValueObject\EmailAddress;
use App\Shared\Domain\ValueObject\UserId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private PasswordRepository $passwordRepository;

    public function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }

    public function load(ObjectManager $manager)
    {
        $user = Admin::create(UserId::random(), EmailAddress::create('abuenosvinos@courses.com'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword($this->passwordRepository->create($user, 'abuenosvinosPass1'));
        $manager->persist($user);

        $user = User::create(UserId::random(), EmailAddress::create('manolo@courses.com'));
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordRepository->create($user, 'manoloPass1'));
        $manager->persist($user);

        $manager->flush();
    }
}
