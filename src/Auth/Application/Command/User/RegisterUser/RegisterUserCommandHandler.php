<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\RegisterUser;

use App\Auth\Domain\User;
use App\Shared\Application\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = $this->commandToEntity($command);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function commandToEntity(RegisterUserCommand $command): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $command->password);

        $user->setEmail($command->email);
        $user->setFirstName($command->firstName);
        $user->setLastName($command->lastName);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
