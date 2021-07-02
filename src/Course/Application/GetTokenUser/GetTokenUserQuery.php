<?php

declare(strict_types=1);

namespace App\Course\Application\GetTokenUser;

use App\Shared\Domain\Bus\Query\Query;

final class GetTokenUserQuery extends Query
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        parent::__construct();

        $this->username = $username;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
