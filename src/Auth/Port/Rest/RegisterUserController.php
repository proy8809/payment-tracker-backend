<?php

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\RegisterUser\RegisterUserCommand;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterUserController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    #[Route('/user', name: 'register_user', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $command = new RegisterUserCommand(
            email: $request->getPayload()->get('email'),
            firstName: $request->getPayload()->get('firstName'),
            lastName: $request->getPayload()->get('lastName'),
            password: $request->getPayload()->get('password'),
            passwordConfirmation: $request->getPayload()->get('passwordConfirmation')
        );

        $this->commandBus->handle($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
