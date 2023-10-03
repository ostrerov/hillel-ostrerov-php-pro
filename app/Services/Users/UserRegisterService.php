<?php

namespace App\Services\Users;

use App\Repositories\Users\Iterators\UserIterator;
use App\Repositories\Users\NewUserDTO;
use App\Repositories\Users\UserRepository;

class UserRegisterService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {
    }

    public function register(NewUserDTO $DTO): UserIterator
    {
        $userId = $this->userRepository->register($DTO);

        return $this->userRepository->getUserById($userId);
    }
}
