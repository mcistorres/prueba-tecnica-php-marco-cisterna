<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class UserDoesNotExistException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct("Usuario con ID {$id} no encontrado");
    }
} 