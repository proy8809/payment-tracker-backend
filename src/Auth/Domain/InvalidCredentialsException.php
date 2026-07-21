<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Shared\Port\Exception\ApiException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class InvalidCredentialsException extends RuntimeException
{
    private const int STATUS = Response::HTTP_FORBIDDEN;
    private const string ERROR_CODE = 'INVALID_CREDENTIALS';

    public function __construct()
    {
        parent::__construct(message: 'Invalid Credentials');
    }

    public function toApiException(): ApiException
    {
        return new ApiException(message: $this->getMessage(), status: self::STATUS, errorCode: self::ERROR_CODE);
    }
}
