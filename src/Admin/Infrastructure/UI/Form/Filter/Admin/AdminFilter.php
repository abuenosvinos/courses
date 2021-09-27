<?php

namespace App\Admin\Infrastructure\UI\Form\Filter\Admin;

use App\Admin\Infrastructure\UI\Form\Filter\BaseFilter;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filter;
use App\Shared\Domain\Criteria\FilterField;
use App\Shared\Domain\Criteria\FilterOperator;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\FilterValue;
use App\Shared\Domain\Criteria\Order;
use App\Shared\Domain\Criteria\OrderBy;
use Symfony\Component\Form\FormInterface;

class AdminFilter extends BaseFilter
{
    public function getCriteria(FormInterface $filterForm): Criteria
    {
        $filters = null;
        $filterForm->handleRequest($this->request);
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();

            $filters = [
                new Filter(
                    new FilterField('username.value'),
                    new FilterOperator(FilterOperator::CONTAINS),
                    new FilterValue($data['username_value'])
                )
            ];
        }

        $page = $this->request->query->get('page', 1);
        $limit = 10;
        $offset = (($page - 1) * $limit);

        return new Criteria(
            new Filters($filters),
            Order::createDesc(OrderBy::create('id')),
            $offset,
            $limit
        );
    }
}
