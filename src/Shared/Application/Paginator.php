<?php

declare(strict_types=1);

namespace App\Shared\Application;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class Paginator implements Countable, IteratorAggregate
{
    private ArrayIterator $results;
    private int $count;

    public function __construct(ArrayIterator $results, int $count)
    {
        $this->results = $results;
        $this->count = $count;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->results;
    }

    public function count(): int
    {
        return $this->count;
    }
}
