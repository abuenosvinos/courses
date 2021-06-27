<?php

declare(strict_types=1);

namespace App\Course\Application\ListCategories;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class ListCategoriesQueryHandler implements QueryHandler
{
    private ListCategories $listCategories;

    public function __construct(ListCategories $listCategories)
    {
        $this->listCategories = $listCategories;
    }

    public function __invoke(ListCategoriesQuery $query)
    {
        return $this->listCategories->__invoke();
    }
}
