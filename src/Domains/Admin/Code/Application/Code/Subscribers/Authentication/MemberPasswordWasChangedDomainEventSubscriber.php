<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Code\Application\Code\Subscribers\Authentication;

use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberPasswordWasChangedDomainEvent;
use Project\Domains\Admin\Code\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Admin\Code\Domain\Code\ValueObjects\Type;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class MemberPasswordWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CodeRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            MemberPasswordWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(MemberPasswordWasChangedDomainEvent $event): void
    {
        $code = $this->repository->findByAuthorUuidAndType(
            AuthorUuid::fromValue($event->memberUuid),
            Type::fromValue($event->type)
        );

        if ($code === null) {
            return;
        }

        $this->repository->delete($code);
    }
}