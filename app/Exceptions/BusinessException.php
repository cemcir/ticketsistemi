<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
