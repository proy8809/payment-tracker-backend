<?php

declare(strict_types=1);

namespace App\Shared\Port\Rest;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class QueryController extends BaseController
{
    public function __construct(
        protected readonly QueryBusInterface $queryBus,
        private readonly ValidatorInterface $validator
    ) {
        parent::__construct($this->validator);
    }
}
