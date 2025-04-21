<?php

namespace App\Controller;

use App\Exception\Validation\ValidationException;
use App\Model\GoodsDTO;
use App\Request\AddGoodRequest;
use App\Request\GetGoodsRequest;
use App\Service\Good\AddGoodsInterface;
use App\Service\Good\GetGoodsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GoodsController extends AbstractController
{
    private NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    #[Route('/api/goods', name: 'goods_list', methods: ['GET'])]
    public function getList(GetGoodsRequest $request, GetGoodsInterface $goodService): JsonResponse
    {
        $page = $request->page;
        $limit = $request->limit;
        $name = $request->name;

        $goods = $goodService->getGoods($page, $limit, $name);

        if (!$goods) {
            return $this->json([], 404);
        }

        $jsonGoods = $this->normalizer->normalize($goods);

        return $this->json($jsonGoods);
    }

    #[Route('/api/goods', name: 'add_good', methods: ['POST'])]
    public function addGood(AddGoodRequest $request, AddGoodsInterface $goodService): JsonResponse
    {
        try {
            $good = $goodService->addGood(GoodsDto::fromRequest($request));
        } catch (ValidationException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $jsonGoods = $this->normalizer->normalize($good);

        return $this->json($jsonGoods, 201);
    }
}
