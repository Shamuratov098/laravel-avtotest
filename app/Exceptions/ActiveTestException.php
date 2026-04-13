<?php

namespace App\Exceptions;

use Exception;

class ActiveTestException extends Exception
{
    public function __construct()
    {
        parent::__construct('Sizda allaqachon aktiv test mavjud.', 422);
    }
}
