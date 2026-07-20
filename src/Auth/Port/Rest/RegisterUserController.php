<?php

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\RegisterUser\RegisterUserCommand;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Port\Rest\BaseController;
use App\Shared\Port\Rest\CommandController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterUserController extends CommandController
{
    #[Route('/user', name: 'register_user', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): JsonResponse {
        $command = new RegisterUserCommand(
            email: $request->getPayload()->get('email'),
            firstName: $request->getPayload()->get('firstName'),
            lastName: $request->getPayload()->get('lastName'),
            password: $request->getPayload()->get('password'),
            passwordConfirmation: $request->getPayload()->get('passwordConfirmation'),
        );

        if ($errors = $this->validate($command)) {
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->commandBus->handle($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
