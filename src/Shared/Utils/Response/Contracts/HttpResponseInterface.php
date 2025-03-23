<?php

namespace Project\Shared\Utils\Response\Contracts;

interface HttpResponseInterface
{
    public function toHttpResponse(): array;
}