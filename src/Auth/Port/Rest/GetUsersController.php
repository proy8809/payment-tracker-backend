<?php

declare(strict_types=1);

namespace App\Auth\Port\Rest;

use App\Auth\Application\Query\User\GetUsers\GetUsersQuery;
use App\Shared\Port\Rest\QueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetUsersController extends QueryController
{
    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $query = new GetUsersQuery(
            page: $request->query->get('page', 1),
            limit: $request->query->get('limit', 10),
        );

        if ($errors = $this->validate($query)) {
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $users = $this->queryBus->ask($query);

        return new JsonResponse($users, Response::HTTP_OK);
    }
}
