<?php

declare(strict_types=1);

namespace Project\Shared\Utils\Response\Contracts;

interface ResponseInterface
{
    public function json($data = [], $status = 200, array $headers = [], $options = 0);

    public function noContent($status = 204, array $headers = []);
}