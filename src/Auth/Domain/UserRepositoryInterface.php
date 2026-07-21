<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function findPaginated(int $page, int $limit): Paginator;

    public function deleteById(int $id): bool;
}
