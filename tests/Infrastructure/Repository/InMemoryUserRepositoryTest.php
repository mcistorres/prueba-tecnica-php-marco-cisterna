<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Exception\UserDoesNotExistException;
use App\Infrastructure\Repository\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    private InMemoryUserRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new InMemoryUserRepository();
    }

    public function testSaveAndRetrieveUser(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $this->repository->save($user);

        $retrievedUser = $this->repository->getById($user->getId());
        $this->assertNotNull($retrievedUser);
        $this->assertEquals($user->getId(), $retrievedUser->getId());
    }

    public function testGetByIdOrFailThrowsException(): void
    {
        $this->expectException(UserDoesNotExistException::class);
        $this->repository->getByIdOrFail('non-existent-id');
    }

    public function testUpdateUser(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $this->repository->save($user);

        $user->setName('Jane Doe');
        $this->repository->update($user);

        $updatedUser = $this->repository->getById($user->getId());
        $this->assertEquals('Jane Doe', $updatedUser->getName());
    }

    public function testUpdateNonExistentUser(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        
        $this->expectException(UserDoesNotExistException::class);
        $this->repository->update($user);
    }

    public function testDeleteUser(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $this->repository->save($user);

        $this->repository->delete($user->getId());
        
        $this->assertNull($this->repository->getById($user->getId()));
    }

    public function testDeleteNonExistentUser(): void
    {
        $this->expectException(UserDoesNotExistException::class);
        $this->repository->delete('non-existent-id');
    }

    public function testGetByEmail(): void
    {
        $user = new User('John Doe', 'john@example.com', 'password123');
        $this->repository->save($user);

        $foundUser = $this->repository->getByEmail('john@example.com');
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->getId(), $foundUser->getId());

        $notFoundUser = $this->repository->getByEmail('nonexistent@example.com');
        $this->assertNull($notFoundUser);
    }

    public function whenUserIsNotFoundByIdErrorIsThrown(): void
    {
        $this->expectException(UserDoesNotExistException::class);
        $this->repository->getByIdOrFail('non-existent-id');
    }
} 