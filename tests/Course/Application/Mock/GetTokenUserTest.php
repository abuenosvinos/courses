<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Mock;

use App\Course\Application\GetTokenUser\GetTokenUser;
use App\Course\Domain\Entity\User;
use App\Course\Domain\Entity\UserId;
use App\Course\Infrastructure\JWT\Decrypt;
use App\Course\Infrastructure\JWT\Encrypt;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetTokenUserTest extends KernelTestCase
{
    private Encrypt $encrypt;
    private Decrypt $decrypt;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->encrypt = $kernel->getContainer()->get('App\Course\Infrastructure\JWT\Encrypt');
        $this->decrypt = $kernel->getContainer()->get('App\Course\Infrastructure\JWT\Decrypt');
    }

    public function testValidValues()
    {
        $userMock = User::create(
            UserId::random(),
            'abuenosvinos'
        );

        $userRepository = $this->createMock(DoctrineUserRepository::class);

        $userRepository->expects($this->any())
            ->method('findByUsername')
            ->willReturn($userMock);

        $entityManager = $this->createMock(EntityManager::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);

        $service = new GetTokenUser(
            $userRepository,
            $this->encrypt
        );

        $token = $service->__invoke('abuenosvinos');

        $this->assertEquals(['username' => 'abuenosvinos'], $this->decrypt->decrypt($token));
    }
}
