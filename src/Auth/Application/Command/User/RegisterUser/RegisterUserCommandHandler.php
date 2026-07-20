<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\RegisterUser;

use App\Auth\Domain\User;
use App\Auth\Domain\UserAlreadyCreatedException;
use App\Auth\Domain\UserRepositoryInterface;
use App\Auth\Infrastructure\Doctrine\UserRepository;
use App\Shared\Application\Command\CommandHandlerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Throwable;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['email' => $command->email]);

        if ($user instanceof User) {
            throw new UserAlreadyCreatedException();
        }

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
