<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Authentication\Subscribers\Client;

use Project\Domains\Admin\Client\Domain\Client\Events\ClientWasCreatedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Account\ValueObjects\Email;
use Project\Infrastructure\Generators\Contracts\PasswordGenerateInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ClientWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private AccountRepositoryInterface $repository,
        private PasswordGenerateInterface $passwordGenerate
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ClientWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ClientWasCreatedDomainEvent $event): void
    {
        $foundAccount = $this->repository->findByEmail(Email::fromValue($event->email));

        if ($foundAccount !== null) {
            return;
        }

        $account = Account::fromPrimitives(
            $event->uuid,
            $event->email,
            $password = $this->passwordGenerate->generate()
        );

        $this->repository->save($account);
    }
}