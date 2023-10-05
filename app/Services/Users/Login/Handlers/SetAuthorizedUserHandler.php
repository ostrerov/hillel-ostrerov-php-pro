<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\Users\UserRepository;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use App\Services\Users\UserAuthService;
use Closure;

class SetAuthorizedUserHandler implements LoginInterface
{
    public function __construct(
        protected UserRepository $userRepository,
        protected UserAuthService $userAuthService,
    ) {
    }

    /**
     * @param LoginDTO $DTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $DTO, Closure $next): LoginDTO
    {
        $user = $this->userRepository->getUserById(
            $this->userAuthService->getUserId()
        );

        $DTO->setUser($user);

        return $next($DTO);
    }
}
