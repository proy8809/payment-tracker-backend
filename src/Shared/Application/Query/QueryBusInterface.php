<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use App\Shared\Application\PaginatedResult;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): PaginatedResult;
}
