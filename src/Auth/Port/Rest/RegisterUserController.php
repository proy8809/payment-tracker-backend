<?php

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\RegisterUser\RegisterUserCommand;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\CommandController;
use App\Shared\Port\Rest\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterUserController extends CommandController
{
    #[Route('/v1/users', name: 'create_user', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): ApiResponse {
        $command = new RegisterUserCommand(
            email: $request->getPayload()->get('email'),
            firstName: $request->getPayload()->get('firstName'),
            lastName: $request->getPayload()->get('lastName'),
            password: $request->getPayload()->get('password'),
            passwordConfirmation: $request->getPayload()->get('passwordConfirmation'),
        );

        if ($errors = $this->validate($command)) {
            throw ApiException::unprocessableEntity($errors);
        }

        $this->commandBus->handle($command);

        return ApiResponse::noContent();
    }
}
