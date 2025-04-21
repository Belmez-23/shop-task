<?php

namespace App\Service\Order;

use App\Entity\Good;
use App\Entity\OrderList;
use App\Entity\OrderGoodsList;
use App\Entity\User;
use App\Exception\Validation\NotFoundException;
use App\Model\OrderDTO;
use App\Model\OrderGoodsDTO;
use App\Service\Order\AddOrderInterface;
use Doctrine\ORM\EntityManagerInterface;

class AddOrderService implements AddOrderInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function addOrder(OrderDTO $orderDTO): ?OrderList
    {
        $user = $this->em->getRepository(User::class)->find($orderDTO->getUserId());

        if (!$user) {
            throw new NotFoundException('Покупатель не найден');
        }

        $goods = $orderDTO->getGoods();

        if (empty($goods)) {
            throw new NotFoundException('В заказе отсутствуют товары');
        }

        $this->validate($goods);

        $order = (new OrderList())
            ->setCreatedAt()
            ->setUser($user)
            ->setAmount(0);

        foreach ($goods as $good) {
            $product = $this->em->getRepository(Good::class)->find($good->getId());
            $product->setCount($product->getCount() - $good->getCount());
            $this->em->persist($product);

            $orderGoods = (new OrderGoodsList())
                ->setGood($product)
                ->setCount($good->getCount())
                ->setOrder($order)
                ->setAmount($product->getPrice() * $good->getCount());

            $order->addGoods($orderGoods);
            $order->setAmount($order->getAmount() + $orderGoods->getAmount());
        }
        $this->em->persist($order);
        $this->em->flush();

        $this->em->refresh($order);

        return $order;
    }

    /**
     * @param OrderGoodsDTO[] $goods
     * @return void
     * @throws NotFoundException
     */
    private function validate(array $goods)
    {
        foreach ($goods as $good) {
            $product = $this->em->getRepository(Good::class)->find($good->getId());

            if (!$product) {
                throw new NotFoundException('Товар не найден');
            }

            if ($product->getCount() < $good->getCount()) {
                throw new NotFoundException('Товаров не хватает на складе, заказ не будет оформлен');
            }
        }
    }
}