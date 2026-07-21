<?php

declare(strict_types=1);

namespace App\Auth\Port\Exception;

use App\Auth\Domain\InvalidCredentialsException;
use App\Auth\Domain\UserAlreadyCreatedException;
use App\Shared\Port\Exception\ApiException;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

trait HandleExceptionTrait
{
    public function handleException(HandlerFailedException $exception): void
    {
        $previousException = $exception->getPrevious();

        if (!$previousException instanceof Exception) {
            throw new ApiException(
                message: 'An exception occurred while processing your request',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
                errorCode: 'INTERNAL_SERVER_ERROR'
            );
        }

        throw match($previousException::class) {
            UserAlreadyCreatedException::class => new ApiException(
                message: 'User already exists.',
                status: Response::HTTP_CONFLICT,
                errorCode: 'USER_ALREADY_EXISTS'
            ),
            InvalidCredentialsException::class => new ApiException(
                message: 'Invalid credentials.',
                status: Response::HTTP_UNAUTHORIZED,
                errorCode: 'INVALID_CREDENTIALS'
            )
        };
    }
}
