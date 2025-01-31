<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Exception\UserDoesNotExistException;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function update(User $user): void;
    public function delete(string $id): void;
    public function getById(string $id): ?User;
    public function getByIdOrFail(string $id): User;
    public function getByEmail(string $email): ?User;
} 