<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Auth\Domain\User;

class UserReadModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->getId(),
            email: $user->getEmail(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
        );
    }
}
