<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface UserRepositoryInterface
{
    public function findUserList(int $page, int $limit): Paginator;

    public function deleteUserById(int $id): bool;
}
