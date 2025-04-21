<?php

namespace App\Normalizer;

use App\Entity\OrderList;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderNormalizer implements NormalizerInterface
{
    use NormalizerAwareTrait;

    /**
     * @param OrderList $data
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(
        mixed $data,
        ?string $format = null,
        array $context = []
    ): array {
        $goodsList = array_map(function ($orderGoods) {
            return [
                'id' => $orderGoods->getGood()->getId(),
                'count' => $orderGoods->getCount(),
                'amount' => $orderGoods->getAmount(),
            ];
        }, $data->getGoodsList()->toArray());

        return [
            'id' => $data->getId(),
            'userId' => $data->getUser()->getId(),
            'goods' => $goodsList,
            'amount' => $data->getAmount(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof OrderList;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['App\Entity\OrderList' => true];
    }
}