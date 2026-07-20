<?php

declare(strict_types=1);

namespace App\Shared\Port\Rest\Controller;

use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class CommandController extends BaseController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        private readonly ValidatorInterface $validator
    ) {
        parent::__construct($this->validator);
    }
}
