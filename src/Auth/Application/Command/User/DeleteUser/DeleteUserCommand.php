<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\DeleteUser;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;


readonly class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(value: 1, message: 'The value must be greater than 0')]
        public int $id
    ) {
    }
}
