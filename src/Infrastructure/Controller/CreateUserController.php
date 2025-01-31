<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\CreateUserRequest;
use App\Application\UseCase\CreateUser;
use App\Domain\Exception\EmailAlreadyExistsException;

class CreateUserController
{
    public function __construct(
        private CreateUser $createUser
    ) {}

    public function __invoke(array $requestData): array
    {
        try {
            $request = new CreateUserRequest(
                $requestData['name'],
                $requestData['email'],
                $requestData['password']
            );

            $user = $this->createUser->execute($request);

            return [
                'success' => true,
                'data' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail()
                ]
            ];
        } catch (EmailAlreadyExistsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        } catch (\InvalidArgumentException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
} 