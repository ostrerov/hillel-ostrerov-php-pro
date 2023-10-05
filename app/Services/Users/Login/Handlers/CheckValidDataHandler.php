<?php

namespace App\Services\Users\Login\Handlers;

use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use App\Services\Users\UserAuthService;
use Closure;

class CheckValidDataHandler implements LoginInterface
{
    public function __construct(
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
        $data = [
            'email' => $DTO->getEmail(),
            'password' => $DTO->getPassword(),
        ];

        if ($this->userAuthService->authAttempt($data) === false) {
            return $DTO;
        }

        return $next($DTO);
    }
}
