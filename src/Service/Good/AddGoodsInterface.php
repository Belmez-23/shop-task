<?php

namespace App\Service\Good;

use App\Entity\Good;
use App\Model\GoodsDTO;

interface AddGoodsInterface
{
    public function addGood(GoodsDto $dto): ?Good;
}