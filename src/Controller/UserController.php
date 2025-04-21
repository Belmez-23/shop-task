<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\Validation\ValidationException;
use App\Model\UserDTO;
use App\Request\AddUserRequest;
use App\Service\User\AddUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserController extends AbstractController
{
    private $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    #[Route('/api/user', name: 'add_user', methods: ['POST'])]
    public function addUser(AddUserRequest $request, AddUserInterface $userService): JsonResponse
    {
        try {
            $user = $userService->addUser(UserDTO::fromRequest($request));
        } catch (ValidationException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $jsonUser = $this->normalizer->normalize($user);

        return $this->json($jsonUser, Response::HTTP_CREATED);
    }
}
