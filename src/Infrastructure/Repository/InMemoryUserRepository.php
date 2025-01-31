<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Exception\UserDoesNotExistException;
use App\Domain\Repository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    /** @var array<string, User> */
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function update(User $user): void
    {
        if (!isset($this->users[$user->getId()])) {
            throw new UserDoesNotExistException($user->getId());
        }
        
        $this->users[$user->getId()] = $user;
    }

    public function delete(string $id): void
    {
        if (!isset($this->users[$id])) {
            throw new UserDoesNotExistException($id);
        }

        unset($this->users[$id]);
    }

    public function getById(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function getByIdOrFail(string $id): User
    {
        $user = $this->getById($id);
        
        if ($user === null) {
            throw new UserDoesNotExistException($id);
        }

        return $user;
    }

    public function getByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }
} 