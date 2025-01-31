<?php

declare(strict_types=1);

namespace Tests\Application\UseCase;

use App\Application\DTO\CreateUserRequest;
use App\Application\UseCase\CreateUser;
use App\Domain\Exception\EmailAlreadyExistsException;
use App\Infrastructure\Repository\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    private InMemoryUserRepository $userRepository;
    private CreateUser $createUser;

    protected function setUp(): void
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->createUser = new CreateUser($this->userRepository);
    }

    public function testCreateUserSuccessfully(): void
    {
        $request = new CreateUserRequest(
            'John Doe',
            'john@example.com',
            'password123'
        );

        $user = $this->createUser->execute($request);

        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        
        // Verificar que el usuario fue guardado en el repositorio
        $savedUser = $this->userRepository->getById($user->getId());
        $this->assertNotNull($savedUser);
        $this->assertEquals($user->getId(), $savedUser->getId());
    }

    public function testCreateUserWithDuplicateEmail(): void
    {
        $request1 = new CreateUserRequest(
            'John Doe',
            'john@example.com',
            'password123'
        );

        $this->createUser->execute($request1);

        $request2 = new CreateUserRequest(
            'Jane Doe',
            'john@example.com',
            'password456'
        );

        $this->expectException(EmailAlreadyExistsException::class);
        $this->createUser->execute($request2);
    }
} 