<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignIn;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SignInCommand
{
    public function __construct(
        #[Assert\NotBlank(message: "User email can't be blank.")]
        public string $email,
        #[Assert\NotBlank(message: "User password can't be blank.")]
        public string $password
    ) {
    }
}
