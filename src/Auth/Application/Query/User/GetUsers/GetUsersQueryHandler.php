<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Auth\Domain\User;
use App\Auth\Domain\UserRepositoryInterface;
use App\Shared\Application\PaginatedResult;
use App\Shared\Application\Query\QueryHandlerInterface;

readonly class GetUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUsersQuery $query): PaginatedResult
    {
        $usersPaginator = $this->userRepository->findUserList($query->page, $query->limit);

        return new PaginatedResult(
            data: array_map(
                static fn (User $user) => UserReadModel::fromEntity($user),
                iterator_to_array($usersPaginator)
            ),
            meta: [
                'currentPage' => $query->page,
                'perPage' => $query->limit,
                'totalItems' => $usersPaginator->count(),
                'totalPages' => (int) ceil($usersPaginator->count() / $query->limit)
            ]
        );
    }
}
