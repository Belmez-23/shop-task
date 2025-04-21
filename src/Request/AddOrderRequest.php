<?php

namespace App\Request;

use App\Request\Resolving\JsonRequestInterface;

final readonly class AddOrderRequest implements Resolving\JsonRequestInterface
{
    /**
     * @param int $userId
     * @param array{array{id: int, count: int}} $goods
     */
    public function __construct(
        public int $userId = 0,
        public array $goods = [],
    ) {
    }
}