<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignUp;

use App\Auth\Domain\User;
use App\Auth\Domain\UserAlreadyCreatedException;
use App\Auth\Infrastructure\Doctrine\UserRepository;
use App\Shared\Application\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class SignUpCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private UserRepository              $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['email' => $command->email]);

        if ($user instanceof User) {
            throw new UserAlreadyCreatedException();
        }

        $user = $this->commandToEntity($command);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function commandToEntity(SignUpCommand $command): User
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
