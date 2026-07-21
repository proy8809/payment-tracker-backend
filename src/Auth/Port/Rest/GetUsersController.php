<?php

declare(strict_types=1);

namespace App\Auth\Port\Rest;

use App\Auth\Application\Query\User\GetUsers\GetUsersQuery;
use App\Auth\Port\Exception\HandleExceptionTrait;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\QueryController;
use App\Shared\Port\Rest\Controller\ValidatesMessageTrait;
use App\Shared\Port\Rest\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

final class GetUsersController extends QueryController
{
    use ValidatesMessageTrait;
    use HandleExceptionTrait;

    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function __invoke(Request $request): ApiResponse
    {
        $query = new GetUsersQuery(
            page: $request->query->getInt('page', 1),
            limit: $request->query->getInt('limit', 10),
        );

        if ($violations = $this->validate($query)) {
            throw ApiException::unprocessableEntity(details: $violations);
        }

        try {
            $paginatedUsers = $this->handleQuery($query);
        } catch (HandlerFailedException $e) {
            $this->handleException($e);
        }

        return ApiResponse::collection($paginatedUsers);
    }
}
