<?php

declare(strict_types=1);

namespace Project\Domains\Client\Code\Application\Code\Subscribers\Authentication;

use Project\Domains\Client\Authentication\Domain\Account\Events\AccountPasswordWasChangedDomainEvent;
use Project\Domains\Client\Code\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\AuthorUuid;
use Project\Domains\Client\Code\Domain\Code\ValueObjects\Type;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class AccountPasswordWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CodeRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            AccountPasswordWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(AccountPasswordWasChangedDomainEvent $event): void
    {
        $code = $this->repository->findByAuthorUuidAndType(
            AuthorUuid::fromValue($event->accountUuid),
            Type::fromValue($event->type)
        );

        if ($code === null) {
            return;
        }

        $this->repository->delete($code);
    }
}