<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Fixtures;

use App\Course\Application\GetTokenUser\GetTokenUser;
use App\Course\Domain\Adapter\EncryptionAdapter;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class GetTokenUserTest extends KernelTestCase
{
    use LoadFixtures;

    private EntityManager $entityManager;
    private EncryptionAdapter $encryptionAdapter;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->encryptionAdapter = $kernel->getContainer()->get('App\Course\Domain\Adapter\EncryptionAdapter');
        $userFixtures = $kernel->getContainer()->get('App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures');

        $this->executeFixtures($this->entityManager, $userFixtures);
    }

    public function testValidValues()
    {
        $userRepository = new DoctrineUserRepository($this->entityManager);

        $userPasswordHasher = $this->createMock(UserPasswordHasher::class);
        $userPasswordHasher->expects($this->any())
            ->method('isPasswordValid')
            ->willReturn(true);

        $service = new GetTokenUser(
            $userRepository,
            $this->encryptionAdapter,
            $userPasswordHasher
        );

        $token = $service->__invoke('abuenosvinos@courses.com', 'abuenosvinosPass');

        $this->assertEquals(['username' => 'abuenosvinos@courses.com'], $this->encryptionAdapter->decrypt($token));
    }
}
