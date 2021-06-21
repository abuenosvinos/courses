<?php

declare(strict_types=1);

namespace App\Course\Application\GetTokenUser;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class GetTokenUserQueryHandler implements QueryHandler
{
    private GetTokenUser $getTokenUser;

    public function __construct(GetTokenUser $getTokenUser)
    {
        $this->getTokenUser = $getTokenUser;
    }

    public function __invoke(GetTokenUserQuery $query)
    {
        return $this->getTokenUser->__invoke($query->username());
    }
}
