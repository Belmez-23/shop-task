<?php

namespace App\Request;

use App\Request\Resolving\JsonRequestInterface;

final readonly class AddUserRequest implements Resolving\JsonRequestInterface
{
    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
    ) {
    }
}