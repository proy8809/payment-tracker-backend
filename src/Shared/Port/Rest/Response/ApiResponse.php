<?php

declare(strict_types=1);

namespace App\Shared\Port\Rest\Response;

use App\Shared\Application\PaginatedResult;
use App\Shared\Port\Exception\ApiException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiResponse extends JsonResponse
{
    public static function item(mixed $data, int $status = Response::HTTP_OK): self {
        return new self(
            data: [
                'data' => $data
            ],
            status: $status
        );
    }

    public static function collection(PaginatedResult $paginated, int $status = Response::HTTP_OK): self
    {
        return new self(
            data: $paginated,
            status: $status
        );
    }

    public static function noContent(): self
    {
        return new self(
            data: null,
            status: Response::HTTP_NO_CONTENT
        );
    }

    public static function fromApiException(ApiException $exception): self
    {
        return new self(
            data: [
                'message' => $exception->getMessage(),
                'status' => $exception->status,
                'errorCode' => $exception->errorCode,
                'details' => $exception->details
            ],
            status: $exception->status
        );
    }

    public static function fromThrowable(Throwable $throwable): self
    {
        return new self(
            data: [
                'message' => $throwable->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'errorCode' => ApiException::INTERNAL_SERVER_ERROR,
            ],
            status: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
