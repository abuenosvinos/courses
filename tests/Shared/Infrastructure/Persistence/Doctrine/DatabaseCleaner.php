<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

use function Lambdish\Phunctional\map;

final class DatabaseCleaner
{
    public function __invoke(EntityManagerInterface $entityManager)
    {
        $connection = $entityManager->getConnection();

        $tables            = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($connection, $tables);

        $connection->executeStatement($truncateTablesSql);
    }

    private function truncateDatabaseSql(Connection $connection, array $tables): string
    {
        $driver = $connection->getParams()['driver'];

        $truncateCommand = '';
        if ($driver === 'pdo_mysql') {
            $truncateCommand .= 'SET FOREIGN_KEY_CHECKS = 0;';
        } elseif ($driver === 'pdo_sqlite') {
            $truncateCommand .= 'PRAGMA foreign_keys = OFF;';
        }

        $truncateTables = map($this->truncateTableSql($connection), $tables);
        $truncateCommand .= implode(' ', $truncateTables);

        if ($driver === 'pdo_mysql') {
            $truncateCommand .= 'SET FOREIGN_KEY_CHECKS = 1;';
        } elseif ($driver === 'pdo_sqlite') {
            $truncateCommand .= 'PRAGMA foreign_keys = ON;';
        }

        return $truncateCommand;
    }

    private function truncateTableSql(Connection $connection): callable
    {
        return function (string $table) use ($connection): string {
            return $connection->getSchemaManager()->getDatabasePlatform()->getTruncateTableSQL($table) . ';';
        };
    }

    private function tables(Connection $connection): array
    {
        return $connection->getSchemaManager()->listTableNames();
    }
}
