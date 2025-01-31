<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use App\Domain\Entity\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreationWithValidData(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');

        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertEquals('password123', $user->getPassword());
        $this->assertNotEmpty($user->getId());
    }

    public function testUserCreationWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido');
        
        new User('John Doe', 'invalid-email', 'password123');
    }

    public function testUserCreationWithShortName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre debe tener al menos 2 caracteres');
        
        new User('J', 'john@example.com', 'password123');
    }

    public function testUserCreationWithShortPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('La contraseña debe tener al menos 6 caracteres');
        
        new User('John Doe', 'john@example.com', '12345');
    }

    public function testSetValidName(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $user->setName('Jane Doe');
        
        $this->assertEquals('Jane Doe', $user->getName());
    }

    public function testSetInvalidName(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre debe tener al menos 2 caracteres');
        
        $user->setName('J');
    }

    public function testSetValidEmail(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $user->setEmail('jane@example.com');
        
        $this->assertEquals('jane@example.com', $user->getEmail());
    }

    public function testSetInvalidEmail(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido');
        
        $user->setEmail('invalid-email');
    }

    public function testSetValidPassword(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $user->setPassword('newpassword123');
        
        $this->assertEquals('newpassword123', $user->getPassword());
    }

    public function testSetInvalidPassword(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('La contraseña debe tener al menos 6 caracteres');
        
        $user->setPassword('12345');
    }

    public function testIdIsUnique(): void
    {
        $user1 = new User('John Doe', 'john@example.com', 'password123');
        $user2 = new User('Jane Doe', 'jane@example.com', 'password456');
        
        $this->assertNotEquals($user1->getId(), $user2->getId());
    }
} 