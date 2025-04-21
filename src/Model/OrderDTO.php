<?php

namespace App\Model;

use App\Request\AddOrderRequest;
use Spatie\DataTransferObject\DataTransferObject;

class OrderDTO extends DataTransferObject
{
    public int $userId = 0;
    /** @var OrderGoodsDTO[] */
    public array $goods = [];

    public static function fromRequest(AddOrderRequest $request): self
    {
        return (new self())
            ->setUserId($request->userId)
            ->setGoods(array_map(fn ($goods) => OrderGoodsDTO::fromArray($goods), $request->goods));
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getGoods(): array
    {
        return $this->goods;
    }

    public function setGoods(array $goods): self
    {
        $this->goods = $goods;

        return $this;
    }
}