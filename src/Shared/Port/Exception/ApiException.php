<?php

declare(strict_types=1);

namespace App\Shared\Port\Exception;


use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiException extends RuntimeException
{
    public const string INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    public const string UNPROCESSABLE_ENTITY = 'UNPROCESSABLE_ENTITY';

    private function __construct(
        string $message = 'An exception occurred while processing your request',
        public readonly int $status = Response::HTTP_INTERNAL_SERVER_ERROR,
        public readonly string $errorCode = self::INTERNAL_SERVER_ERROR,
        public readonly array $details = []
    ) {
        parent::__construct($message, $status);
    }

    public static function internalServerError(string $message, array $details = []): self
    {
        return new self(
            $message,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            self::INTERNAL_SERVER_ERROR,
            $details
        );
    }

    public static function unprocessableEntity(array $details = []): self
    {
        return new self(
            message: 'The request was well-formed but was unable to be followed due to semantic errors.',
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
            errorCode: self::UNPROCESSABLE_ENTITY,
            details: $details
        );
    }
}
