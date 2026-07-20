<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\RegisterUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __invoke(RegisterUserCommand $command): void
    {
        dd($command);
    }
}
