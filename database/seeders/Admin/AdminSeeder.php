<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Manager\Application\Manager\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class AdminSeeder extends Seeder
{
    private array $admins = [
        [
            'email' => 'admin@gmail.com',
            'first_name' => 'Admin',
            'last_name' => 'Adminov',
        ],
        [
            'email' => 'admin2@gmail.com',
            'first_name' => 'Admin2',
            'last_name' => 'Adminov2',
        ],
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) { }

    public function run(): void
    {
        foreach ($this->admins as $admin) {
            [
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ] = $admin;

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
