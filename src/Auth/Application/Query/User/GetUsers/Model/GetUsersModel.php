<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\GetUsers\Model;

use App\Auth\Domain\User;

final readonly class GetUsersModel
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        public int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public array $roles
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->getId(),
            email: $user->getEmail(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            roles: $user->getRoles()
        );
    }
}
