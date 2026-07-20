<?php

declare(strict_types=1);

namespace App\Shared\Application;

final readonly class PaginatedResult
{
    /**
     * @param array $data
     * @param array{currentPage: int, perPage: int, totalItems: int, totalPages: int} $meta
     */
    public function __construct(
        public array $data = [],
        public array $meta = []
    ) {
    }
}
