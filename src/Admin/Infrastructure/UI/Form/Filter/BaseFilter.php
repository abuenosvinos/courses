<?php

namespace App\Admin\Infrastructure\UI\Form\Filter;

use App\Shared\Domain\Criteria\Criteria;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function getCriteria(FormInterface $form): Criteria;

    public function getPath(): string
    {
        return $this->request->get('_route');
    }

    public function getParams(): array
    {
        $params = $this->request->query->all();
        unset($params['page']);

        return $params;
    }
}
