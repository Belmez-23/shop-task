<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Validation\ValidationException;
use App\Model\UserDTO;
use Doctrine\ORM\EntityManagerInterface;

class AddUserService implements AddUserInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function addUser(UserDTO $dto): ?User
    {
        $this->validate($dto);

        $user = (new User())
            ->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName());
        $this->em->persist($user);
        $this->em->flush();

        $this->em->refresh($user);

        return $user;
    }

    private function validate(UserDTO $dto)
    {
        if (!$dto->getFirstName()) {
            throw new ValidationException('Не задано имя пользователя');
        }
        if (!$dto->getLastName()) {
            throw new ValidationException('Не задана фамилия пользователя');
        }
    }
}