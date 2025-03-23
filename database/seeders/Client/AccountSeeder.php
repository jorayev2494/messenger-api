<?php

namespace Database\Seeders\Client;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Client\Application\Client\Commands\Create\Command;
use Project\Domains\Client\Authentication\Domain\Account\Account;
use Project\Domains\Client\Authentication\Domain\Account\AccountRepositoryInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class AccountSeeder extends Seeder
{
    private array $accounts = [
        [
            'first_name' => 'Client',
            'last_name' => 'Clientov',
            'email' => 'client@gmail.com',
        ],
        [
            'first_name' => 'Client2',
            'last_name' => 'Clientov2',
            'email' => 'client2@gmail.com',
        ],
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) { }

    public function run(): void
    {
        foreach ($this->accounts as $account) {
            [
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ] = $account;

            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $email,
                    $firstName,
                    $lastName
                )
            );
        }
    }
}
