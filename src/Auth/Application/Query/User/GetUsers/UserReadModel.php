<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers;

use App\Auth\Domain\User;

readonly class UserReadModel
{
    /**
     * @param array<string> $roles
     */
    private function __construct(
        public int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public array $roles,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getRoles()
        );
    }
}
