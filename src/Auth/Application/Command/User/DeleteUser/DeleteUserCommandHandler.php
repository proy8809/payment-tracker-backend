<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\DeleteUser;

use App\Auth\Domain\UserRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->userRepository->deleteUserById($command->id);
    }
}
