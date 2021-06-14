<?php

declare(strict_types = 1);

namespace App\Course\Application\GetTokenUser;

use App\Shared\Domain\Bus\Query\Query;

final class GetTokenUserQuery extends Query
{
    private string $username;

    public function __construct(string $username)
    {
        parent::__construct();

        $this->username = $username;
    }

    public function username(): string
    {
        return $this->username;
    }
}
