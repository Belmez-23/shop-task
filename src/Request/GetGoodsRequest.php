<?php

namespace App\Request;


use App\Request\Resolving\QueryRequestInterface;
use DateTimeImmutable;

final readonly class GetGoodsRequest implements QueryRequestInterface
{
    public function __construct(
        public string $name = '',
        public int $page = 0,
        public int $limit = self::DEFAULT_LIMIT,
    ) {
    }
}