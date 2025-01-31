<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class EmailAlreadyExistsException extends Exception
{
    public function __construct(string $email)
    {
        parent::__construct("Ya existe un usuario con el email {$email}");
    }
} 