<?php

namespace App\Shared\Application\Transformer;

interface DataTransformer
{
    public function write(mixed $input);

    public function read(): mixed;
}
