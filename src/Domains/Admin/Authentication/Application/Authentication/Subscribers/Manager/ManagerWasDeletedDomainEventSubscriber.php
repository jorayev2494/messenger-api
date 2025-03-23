<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager;

use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasDeletedDomainEvent $event): void
    {
        $foundMember = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($foundMember === null) {
            return;
        }

        $this->repository->delete($foundMember);
    }
}