<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\Messenger;

use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;
use Project\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Project\Shared\Infrastructure\Bus\QueryNotRegistered;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessengerQueryBus implements QueryBusInterface
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(CallableFirstParameterExtractor::forCallables($queryHandlers))
            ),
        ]);
    }

    public function ask(QueryInterface $query): mixed
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegistered('Query ' . get_class($query) . ' not registered.');
        }
    }
}
