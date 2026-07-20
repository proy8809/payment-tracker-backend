<?php

declare(strict_types=1);

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\DeleteUser\DeleteUserCommand;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\CommandController;
use App\Shared\Port\Rest\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DeleteUserController extends CommandController
{
    #[Route('/users', name: 'delete_user', methods: ['DELETE'])]
    public function __invoke(Request $request): ApiResponse {
        $command = new DeleteUserCommand($request->getPayload()->getInt('id'));

        if ($errors = $this->validate($command)) {
            throw ApiException::unprocessableEntity($errors);
        }

        $this->commandBus->handle($command);

        return ApiResponse::noContent();
    }
}
