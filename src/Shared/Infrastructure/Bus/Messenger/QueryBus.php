<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Messenger;

use App\Shared\Application\PaginatedResult;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class QueryBus implements QueryBusInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function ask(QueryInterface $query): PaginatedResult
    {
        $envelope = $this->messageBus->dispatch($query);
        $stamp = $envelope->last(HandledStamp::class);

        return $stamp->getResult();
    }
}
