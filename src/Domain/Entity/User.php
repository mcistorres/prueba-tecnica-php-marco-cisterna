<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class User
{
    private string $id;
    
    public function __construct(
        private string $name,
        private string $email,
        private string $password
    ) {
        $this->validateEmail($email);
        $this->validateName($name);
        $this->validatePassword($password);
        $this->id = uniqid();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->validateName($name);
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->validateEmail($email);
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->validatePassword($password);
        $this->password = $password;
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }
    }

    private function validateName(string $name): void
    {
        if (strlen($name) < 2) {
            throw new InvalidArgumentException('El nombre debe tener al menos 2 caracteres');
        }
    }

    private function validatePassword(string $password): void
    {
        if (strlen($password) < 6) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 6 caracteres');
        }
    }
} 