<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignUp;

use Symfony\Component\Validator\Constraints as Assert;

readonly class SignUpCommand
{
    public function __construct(
        #[Assert\NotBlank(message: "User email can't be blank")]
        #[Assert\Email(message: "User email is not valid")]
        public string $email,
        #[Assert\NotBlank(message: "User first name can't be blank")]
        public string $firstName,
        #[Assert\NotBlank(message: "User last name can't be blank")]
        public string $lastName,
        #[Assert\NotBlank(message: "User password can't be blank")]
        #[Assert\Length(min: 8, minMessage: "User password must be at least {{ limit }} characters long")]
        public string $password,
        #[Assert\NotBlank(message: "User password can't be blank")]
        #[Assert\EqualTo(propertyPath: 'password', message: "User password confirmation must be equal to password")]
        public string $passwordConfirmation
    ) {
    }
}
