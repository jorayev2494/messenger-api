<?php

declare(strict_types=1);

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Role\Application\Role\Commands\Create\Command as RoleCreateCommand;
use Project\Domains\Admin\Role\Application\Permission\Commands\Create\Command as PermissionCreateCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RoleAndPermissionSeeder extends Seeder
{
    public array $roles = [
        [
            'value' => 'Admin',
            'description' => 'Admin description',
            'is_super_admin' => true,
        ],
        [
            'value' => 'Manager',
            'description' => 'Manager description',
        ],
        [
            'value' => 'Moderator',
            'description' => 'Moderator description',
        ],
    ];

    public array $permissions = [
        [
            'resource' => 'manager',
            'actions' => [
                [
                    'index',
                    'create',
                    'show',
                    'update',
                    'delete',
                ],
            ],
        ],
        [
            'resource' => 'client',
            'actions' => [
                [
                    'index',
                    'create',
                    'show',
                    'update',
                    'delete',
                ],
            ],
        ],
        [
            'resource' => 'role',
            'actions' => [
                [
                    'index',
                    'create',
                    'show',
                    'update',
                    'delete',
                ],
            ],
        ],
    ];

    public function __construct(
        private CommandBusInterface $commandBus,
        private UuidGeneratorInterface $uuidGenerator
    ) { }

    public function run(): void
    {
        $this->role();
        $this->permissions();
    }

    private function role(): void
    {
        foreach ($this->roles as $role) {
            ['value' => $value, 'description' => $description] = $role;

            $this->commandBus->dispatch(
                new RoleCreateCommand(
                    $this->uuidGenerator->generate(),
                    $value,
                    $description
                )
            );
        }
    }

    private function permissions(): void
    {
        foreach ($this->permissions as $permission) {
            ['resource' => $resource, 'actions' => $actions] = $permission;
            foreach ($actions as $action) {
                $this->commandBus->dispatch(
                    new PermissionCreateCommand(
                        sprintf('%s %s', ucfirst($resource), $permission),
                        $resource,
                        $action
                    )
                );
            }
        }
    }
}
