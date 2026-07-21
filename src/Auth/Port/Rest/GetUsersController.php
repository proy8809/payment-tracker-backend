<?php

declare(strict_types=1);

namespace App\Auth\Port\Rest;

use App\Auth\Application\Query\User\GetUsers\GetUsersQuery;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\QueryController;
use App\Shared\Port\Rest\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GetUsersController extends QueryController
{
    #[Route('/v1/users', name: 'get_users', methods: ['GET'])]
    public function __invoke(Request $request): ApiResponse
    {
        $query = new GetUsersQuery(
            page: $request->query->getInt('page', 1),
            limit: $request->query->getInt('limit', 10),
        );

        if ($errors = $this->validate($query)) {
            throw ApiException::unprocessableEntity($errors);
        }

        $paginatedUsers = $this->queryBus->ask($query);

        return ApiResponse::collection($paginatedUsers);
    }
}
