<?php

namespace App\Services\Users;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\UserRepository;

class UserLoginService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserAuthService $userAuthService,
    ) {
    }

    public function login(array $data): ?UserIterator
    {
        $isUserDataCorrect = $this->userAuthService->authAttempt($data);

        if ($isUserDataCorrect === false) {
            return null;
        }

        $userId = $this->userAuthService->getUserId();
        return $this->getUserById($userId);
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }
}
