<?php

namespace App\Service\Good;

use App\Entity\Good;

interface GetGoodsInterface
{
    /**
     * @return Good[]|null
     */
    public function getGoods(int $page, int $limit, ?string $name = null): ?array;

    public function getGoodsCount(?string $name = null): int;

    public function getGoodById(int $id): ?Good;

}