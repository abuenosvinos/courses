<?php

declare(strict_types=1);

namespace App\Tests\Course\Application\Fixtures;

use App\Course\Application\GetTokenUser\GetTokenUser;
use App\Course\Domain\Adapter\EncryptionAdapter;
use App\Course\Infrastructure\Persistence\Doctrine\DataFixtures\UserFixtures;
use App\Course\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Tests\Shared\Infrastructure\Fixtures\LoadFixtures;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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

        $this->executeFixtures($this->entityManager, new UserFixtures());
    }

    public function testValidValues()
    {
        $userRepository = new DoctrineUserRepository($this->entityManager);

        $service = new GetTokenUser(
            $userRepository,
            $this->encryptionAdapter
        );

        $token = $service->__invoke('abuenosvinos');

        $this->assertEquals(['username' => 'abuenosvinos'], $this->encryptionAdapter->decrypt($token));
    }
}
