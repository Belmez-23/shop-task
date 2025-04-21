<?php

namespace App\Model;

use App\Request\AddUserRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UserDTO extends DataTransferObject
{
    private string $firstName = '';
    private string $lastName = '';

    public static function fromRequest(AddUserRequest $request): self
    {
        return (new self())
            ->setFirstName($request->firstName)
            ->setLastName($request->lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}