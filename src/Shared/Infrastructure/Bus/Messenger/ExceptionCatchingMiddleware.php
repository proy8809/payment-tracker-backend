<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Messenger;

use App\Shared\Domain\MapsToApiExceptionInterface;
use App\Shared\Port\Exception\ApiException;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class ExceptionCatchingMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (HandlerFailedException $handlerFailedException) {
            $domainException = $handlerFailedException->getPrevious();

            if (!$domainException instanceof Exception) {
                throw ApiException::internalServerError('An internal server error occurred.');
            }

            if ($domainException instanceof MapsToApiExceptionInterface) {
                throw $domainException->toApiException();
            }

            throw ApiException::internalServerError($domainException->getMessage());
        }
    }
}
