<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\Validation\NotFoundException;
use App\Exception\Validation\ValidationException;
use App\Model\OrderDTO;
use App\Request\AddOrderRequest;
use App\Service\Order\AddOrderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderController extends AbstractController
{
    private $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    #[Route('/api/order', name: 'add_order', methods: ['POST'])]
    public function index(AddOrderRequest $request, AddOrderInterface $orderService): JsonResponse
    {
        try {
            $order = $orderService->addOrder(OrderDTO::fromRequest($request));
        } catch (NotFoundException|ValidationException $exception) {
            return $this->json(['error' => $exception->getMessage()], $exception->getCode());
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $jsonOrder = $this->normalizer->normalize($order);

        return $this->json($jsonOrder, Response::HTTP_CREATED);
    }
}
