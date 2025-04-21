<?php

namespace App\Exception\Validation;

class NotFoundException extends \Exception
{
    protected $message = 'Entity not found';
    protected $code = 400;
}