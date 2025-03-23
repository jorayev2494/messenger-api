<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Subscribers\Manager;

use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Password;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Infrastructure\Generators\Contracts\PasswordGenerateInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MemberRepositoryInterface $repository,
        private PasswordGenerateInterface $passwordGenerate
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasCreatedDomainEvent $event): void
    {
        $foundMember = $this->repository->findByEmail(Email::fromValue($event->email));

        if ($foundMember !== null) {
            return;
        }

        $member = Member::create(
            Uuid::fromValue($event->uuid),
            Email::fromValue($event->email),
            Password::fromValue($generatePassword = $this->passwordGenerate->generate(Password::LENGTH))
        );

        $this->repository->save($member);
    }
}