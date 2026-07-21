<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class GetUsersQuery implements QueryInterface
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(value: 1, message: 'The value must be greater than 0')]
        public int $page,
        #[Assert\GreaterThanOrEqual(value: 1, message: 'The value must be greater than 0')]
        public int $limit
    ) {
    }
}
