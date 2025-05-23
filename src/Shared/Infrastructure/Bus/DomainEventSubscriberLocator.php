<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus;

use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;
// use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

use RuntimeException;
use Traversable;

use function Lambdish\Phunctional\search;

final class DomainEventSubscriberLocator implements LocatorInterface
{
    private readonly array $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }

//    public function withRabbitMqQueueNamed(string $queueName): DomainEventSubscriberInterface|callable
//    {
//        $subscriber = search(
//            static fn (DomainEventSubscriberInterface $subscriber) => (RabbitMqQueueNameFormatter::format($subscriber)) === $queueName,
//            $this->mapping
//        );
//
//        if (null === $subscriber) {
//            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
//        }
//
//        return $subscriber;
//    }

    /**
     * @return array<array-key, DomainEventSubscriberInterface>
     */
    public function all(): array
    {
        return $this->mapping;
    }

//    public function getRegisteredSubscribers(): array
//    {
//        $list = array_map(
//            static fn (DomainEventSubscriberInterface $subscriber) => RabbitMqQueueNameFormatter::format($subscriber),
//            $this->mapping
//        );
//
//        return $list;
//    }
}