<?php

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\SignUp\SignUpCommand;
use App\Auth\Domain\UserAlreadyCreatedException;
use App\Auth\Port\Exception\HandleExceptionTrait;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\CommandController;
use App\Shared\Port\Rest\Controller\ValidatesMessageTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

final class SignUpController extends CommandController
{
    use ValidatesMessageTrait;
    use HandleExceptionTrait;

    #[Route('/signup', name: 'signup', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $command = new SignUpCommand(
            email: $request->getPayload()->get('email'),
            firstName: $request->getPayload()->get('firstName'),
            lastName: $request->getPayload()->get('lastName'),
            password: $request->getPayload()->get('password'),
            passwordConfirmation: $request->getPayload()->get('passwordConfirmation'),
        );

        if ($errors = $this->validate($command)) {
            throw ApiException::unprocessableEntity(details: $errors);
        }

        try {
            $this->handleCommand($command);
        } catch (HandlerFailedException $e) {
            $this->handleException($e);
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
