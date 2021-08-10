<?php

declare(strict_types=1);

namespace App\Tests\Course\Application;

use App\Course\Application\AddUser\AddUser;
use App\Shared\Domain\Repository\PasswordRepository;
use App\Shared\Domain\ValueObject\Password;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Tests\Shared\Domain\EmailAddressMother;
use App\Tests\Shared\Domain\PasswordMother;
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
        $username = EmailAddressMother::random();
        $password = Password::create(PasswordMother::random());

        $userRepository = new DoctrineUserRepository($this->entityManager);
        $userPasswordHasher = $this->createMock(PasswordRepository::class);
        $userPasswordHasher->expects($this->any())
            ->method('create')
            ->willReturn($password);

        $service = new AddUser(
            $userRepository,
            $userPasswordHasher
        );

        $service->__invoke(
            $username,
            $password->value()
        );

        $user = $userRepository->findByUsername($username);

        $this->assertEquals($user->username()->value(), $username);
    }
}
