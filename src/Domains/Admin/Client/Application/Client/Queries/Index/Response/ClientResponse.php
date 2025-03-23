<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Client\Queries\Index\Response;

use OpenApi\Attributes as OA;
use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Shared\Contracts\ArrayableInterface;

#[OA\Schema(schema: 'Admin:Client:IndexResponseSchema')]
readonly class ClientResponse implements ArrayableInterface
{
    #[OA\Property(example: 'aabe3af0-4348-4492-bbae-ac4e40c83ef8', uniqueItems: true)]
    protected string $uuid;

    #[OA\Property(example: 'manager@gmail.com', uniqueItems: true)]
    protected string $email;

    #[OA\Property(property: 'first_name', example: 'Client')]
    protected ?string $firstName;

    #[OA\Property(property: 'last_name', example: 'Clientov')]
    protected ?string $lastName;

    private function __construct(Client $client)
    {
        $this->uuid = $client->getUuid()->value;
        $this->email = $client->getEmail()->value;
        $this->firstName = $client->getFirstName()->value;
        $this->lastName = $client->getLastName()->value;
    }

    public static function make(Client $client): self
    {
        return new self($client);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
