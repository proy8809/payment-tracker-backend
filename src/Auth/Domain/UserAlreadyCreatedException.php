<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Shared\Domain\MapsToApiExceptionInterface;
use App\Shared\Port\Exception\ApiException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyCreatedException extends RuntimeException implements MapsToApiExceptionInterface
{
    private const int STATUS = Response::HTTP_CONFLICT;
    private const string ERROR_CODE = 'USER_ALREADY_EXISTS';

    public function __construct()
    {
        parent::__construct(message: 'This user was already created');
    }

    public function toApiException(): ApiException
    {
        return new ApiException(message: $this->getMessage(), status: self::STATUS, errorCode: self::ERROR_CODE);
    }
}
