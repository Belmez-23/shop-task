<?php

namespace App\Model;

use App\Request\AddGoodRequest;
use Spatie\DataTransferObject\DataTransferObject;

class GoodsDTO extends DataTransferObject
{
    private string $title = '';
    private float $price = 0;
    private int $count = 0;

    public static function fromRequest(AddGoodRequest $request): self
    {
        return (new self())
            ->setTitle($request->title)
            ->setPrice($request->price)
            ->setCount($request->count);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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