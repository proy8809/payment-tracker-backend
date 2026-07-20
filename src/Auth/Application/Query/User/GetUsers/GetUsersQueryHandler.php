<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Auth\Domain\User;
use App\Auth\Domain\UserRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

readonly class GetUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @return UserReadModel[]
     */
    public function __invoke(GetUsersQuery $query): array
    {
        $paginator = $this->userRepository->findUserList($query->page, $query->limit);

        return array_map(
            static fn(User $user) => UserReadModel::fromEntity($user),
            iterator_to_array($paginator),
        );
    }
}
