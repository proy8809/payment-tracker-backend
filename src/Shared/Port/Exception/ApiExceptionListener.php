<?php

declare(strict_types=1);

namespace App\Shared\Port\Exception;

use App\Shared\Port\Rest\Response\ApiResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ApiException) {
            $event->setResponse(ApiResponse::fromApiException($exception));
            return;
        }

        $event->setResponse(ApiResponse::fromThrowable($exception));
    }
}
