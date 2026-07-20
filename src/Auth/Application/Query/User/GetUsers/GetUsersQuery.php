<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Shared\Application\Query\QueryInterface;

readonly class GetUsersQuery implements QueryInterface
{
    public function __construct(
        public int $page,
        public int $limit
    ) {
    }
}
