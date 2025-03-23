<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Subscribers\Client;

use Project\Domains\Admin\Client\Domain\Client\Events\ClientWasDeletedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ClientWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private AccountRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ClientWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ClientWasDeletedDomainEvent $event): void
    {
        $foundAccount = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($foundAccount === null) {
            return;
        }

        $this->repository->delete($foundAccount);
    }
}