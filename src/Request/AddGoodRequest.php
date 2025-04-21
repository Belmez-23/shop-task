<?php

namespace App\Request;

use App\Request\Resolving\JsonRequestInterface;

final readonly class AddGoodRequest implements JsonRequestInterface
{
    public function __construct(
        public string $title = '',
        public float $price = 0,
        public int $count = 0,
    ) {
    }
}