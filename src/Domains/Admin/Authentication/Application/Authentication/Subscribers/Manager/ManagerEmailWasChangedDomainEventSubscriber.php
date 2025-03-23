<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager;

use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerEmailWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerEmailWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerEmailWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerEmailWasChangedDomainEvent $event): void
    {
        $foundMember = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($foundMember === null) {
            return;
        }

        $foundMember->setEmail(Email::fromValue($event->email));

        $this->repository->save($foundMember);
    }
}