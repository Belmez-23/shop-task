<?php

namespace App\Model;

use Spatie\DataTransferObject\DataTransferObject;

class OrderGoodsDTO extends DataTransferObject
{
    public int $id = 0;
    public int $count = 0;

    public static function fromArray(array $goods): OrderGoodsDTO
    {
        return (new self())->setId($goods['id'])->setCount($goods['count']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

}