<?php

namespace App\Exception\Validation;

class ValidationException extends \Exception
{
    protected $message = 'Validation failed';
    protected $code = 400;
}