<?php

namespace App\Service\Good;

use App\Entity\Good;
use App\Exception\Validation\ValidationException;
use App\Model\GoodsDTO;
use Doctrine\ORM\EntityManagerInterface;

class AddGoodsService implements AddGoodsInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function addGood(GoodsDto $dto): Good
    {
        $this->validate($dto);
        
        $good = (new Good())
            ->setTitle($dto->getTitle())
            ->setPrice($dto->getPrice())
            ->setCount($dto->getCount())
            ->setCreatedAt();

        $this->em->persist($good);
        $this->em->flush();

        $this->em->refresh($good);

        return $good;
    }

    private function validate(GoodsDTO $dto)
    {
        if (!$dto->getTitle()) {
            throw new ValidationException('Не задано наименование товара');
        }

        if (!$dto->getPrice() || $dto->getPrice() < 0) {
            throw new ValidationException('Не задана цена товара');
        }
        
        if (!$dto->getCount() || $dto->getCount() < 0) {
            throw new ValidationException('Не задано количество товара');
        }
    }
}