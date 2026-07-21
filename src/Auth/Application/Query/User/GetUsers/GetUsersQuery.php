<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetUsersQuery
{
    public function __construct(
        #[Assert\GreaterThan(value: 0, message: "Page must be greater than 0.")]
        public int $page,
        #[Assert\GreaterThan(value: 0, message: "Limit must be greater than 0.")]
        public int $limit
    ) {
    }
}
