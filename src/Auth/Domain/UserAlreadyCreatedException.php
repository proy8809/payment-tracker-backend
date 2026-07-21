<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use RuntimeException;

class UserAlreadyCreatedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(message: 'This user was already created');
    }
}
