<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\DeleteUser;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteUserCommand
{
    public function __construct(
        #[Assert\GreaterThan(value: 0, message: "User id must be greater than 0.")]
        public int $id
    ) {
    }
}
