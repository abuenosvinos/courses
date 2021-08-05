<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Mock;

use App\Course\Application\GetTokenUser\GetTokenUser;
use App\Course\Domain\Adapter\EncryptionAdapter;
use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class GetTokenUserTest extends KernelTestCase
{
    private EncryptionAdapter $encryptionAdapter;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->encryptionAdapter = $kernel->getContainer()->get('App\Course\Domain\Adapter\EncryptionAdapter');
    }

    public function testValidValues()
    {
        $userMock = User::create(
            UserId::random(),
            'abuenosvinos@courses.com'
        );

        $userRepository = $this->createMock(DoctrineUserRepository::class);

        $userRepository->expects($this->any())
            ->method('findByUsername')
            ->willReturn($userMock);

        $entityManager = $this->createMock(EntityManager::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);

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
