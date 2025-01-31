<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\CreateUserRequest;
use App\Domain\Entity\User;
use App\Domain\Exception\EmailAlreadyExistsException;
use App\Domain\Repository\UserRepositoryInterface;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(CreateUserRequest $request): User
    {
        $existingUser = $this->userRepository->getByEmail($request->getEmail());
        
        if ($existingUser !== null) {
            throw new EmailAlreadyExistsException($request->getEmail());
        }

        $user = new User(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );

        $this->userRepository->save($user);

        return $user;
    }
} 