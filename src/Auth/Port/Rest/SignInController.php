<?php

declare(strict_types=1);

namespace App\Auth\Port\Rest;

use App\Auth\Application\Command\User\SignIn\SignInCommand;
use App\Auth\Port\Exception\HandleExceptionTrait;
use App\Shared\Port\Exception\ApiException;
use App\Shared\Port\Rest\Controller\CommandController;
use App\Shared\Port\Rest\Controller\ValidatesMessageTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

final class SignInController extends CommandController
{
    use ValidatesMessageTrait;
    use HandleExceptionTrait;

    #[Route('/signin', name: 'signin', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $command = new SignInCommand(
            email: $request->request->get('email'),
            password: $request->request->get('password')
        );

        if ($violations = $this->validate($command)) {
            throw ApiException::unprocessableEntity(details: $violations);
        }

        try {
            $token = $this->handleCommand($command);
        } catch (HandlerFailedException $e) {
            $this->handleException($e);
        }

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}
