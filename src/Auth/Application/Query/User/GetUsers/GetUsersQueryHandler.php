<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Auth\Application\Query\User\GetUsers\Model\GetUsersModel;
use App\Auth\Domain\User;
use App\Auth\Domain\UserRepositoryInterface;
use App\Shared\Application\PaginatedResult;
use App\Shared\Application\QueryHandlerInterface;

final readonly class GetUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUsersQuery $query): PaginatedResult
    {
        $paginator = $this->userRepository->findPaginated(page: $query->page, limit: $query->limit);

        return new PaginatedResult(
            data: array_map(static fn (User $user) => GetUsersModel::fromEntity($user), iterator_to_array($paginator)),
            meta: [
                "currentPage" => $query->page,
                "perPage" => $query->limit,
                "totalPages" => (int) ceil($paginator->count() / $query->limit),
                "totalItems" => $paginator->count()
            ]
        );
    }
}
