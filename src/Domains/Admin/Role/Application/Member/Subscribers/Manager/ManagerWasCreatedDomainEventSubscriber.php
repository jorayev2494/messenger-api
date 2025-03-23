<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Member\Subscribers\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Admin\Role\Domain\Member\Member;
use Project\Domains\Admin\Role\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasCreatedDomainEvent $event): void
    {
        $foundMember = $this->repository->findByUuid($uuid = Uuid::fromValue($event->uuid));

        if ($foundMember !== null) {
            return;
        }

        $member = Member::create($uuid);

        $this->repository->save($member);
    }
}