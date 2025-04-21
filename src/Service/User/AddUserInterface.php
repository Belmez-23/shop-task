<?php

namespace App\Service\User;

use App\Entity\User;
use App\Model\UserDTO;

interface AddUserInterface
{
    public function addUser(UserDto $dto): ?User;
}