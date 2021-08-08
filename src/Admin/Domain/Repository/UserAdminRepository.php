<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Shared\Application\Paginator;
use App\Shared\Domain\Criteria\Criteria;

interface UserAdminRepository
{
    public function search(Criteria $criteria): Paginator;
}
