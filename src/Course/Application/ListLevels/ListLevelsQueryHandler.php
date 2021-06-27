<?php

declare(strict_types=1);

namespace App\Course\Application\ListLevels;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class ListLevelsQueryHandler implements QueryHandler
{
    private ListLevels $listLevels;

    public function __construct(ListLevels $listLevels)
    {
        $this->listLevels = $listLevels;
    }

    public function __invoke(ListLevelsQuery $query)
    {
        return $this->listLevels->__invoke();
    }
}
