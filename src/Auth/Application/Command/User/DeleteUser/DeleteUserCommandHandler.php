<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\DeleteUser;

use App\Auth\Domain\UserRepositoryInterface;
use App\Shared\Application\CommandHandlerInterface;

final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(DeleteUserCommand $command): bool
    {
        return $this->userRepository->deleteById($command->id);
    }
}
