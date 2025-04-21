<?php

namespace App\Service\Order;

use App\Entity\OrderList;
use App\Model\OrderDTO;

interface AddOrderInterface
{
    public function addOrder(OrderDTO $orderDTO): ?OrderList;
}