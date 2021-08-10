<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\AddUser\AddUser;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Tests\Shared\Domain\EmailAddressMother;
use App\Tests\Shared\Domain\StringMother;
use App\Tests\Shared\Infrastructure\Persistence\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

use function Lambdish\Phunctional\apply;

class AddUserTest extends KernelTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        apply(new DatabaseCleaner(), [$this->entityManager]);
    }

    public function testValidValues()
    {
        $userRepository = new DoctrineUserRepository($this->entityManager);
        $passwordHasher = $this->createMock(UserPasswordHasher::class);

        $service = new AddUser(
            $userRepository,
            $passwordHasher
        );

        $username = EmailAddressMother::random();
        $password = StringMother::random();

        $service->__invoke(
            $username,
            $password
        );

        $user = $userRepository->findByUsername($username);

        $this->assertEquals($user->username()->value(), $username);
    }
}
