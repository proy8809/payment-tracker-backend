<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignIn;

use App\Auth\Domain\UserRepositoryInterface;
use App\Auth\Domain\InvalidCredentialsException;
use App\Shared\Application\CommandHandlerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class SignInCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtTokenManager
    ) {
    }

    public function __invoke(SignInCommand $command): string
    {
        if (!$user = $this->userRepository->findByEmail($command->email)) {
            throw new InvalidCredentialsException();
        }

        if (!$this->passwordHasher->isPasswordValid($user, $command->password)) {
            throw new InvalidCredentialsException();
        }

        return $this->jwtTokenManager->create($user);
    }
}
