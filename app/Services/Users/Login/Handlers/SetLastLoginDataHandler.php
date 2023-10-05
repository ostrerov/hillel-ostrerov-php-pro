<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\LastLoginData\LastLoginDataRepository;
use App\Services\RequestService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use Closure;

class SetLastLoginDataHandler implements LoginInterface
{
    public function __construct(
        protected LastLoginDataRepository $lastLoginDataRepository,
        protected RequestService $requestService,
    ) {
    }

    /**
     * @param LoginDTO $DTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $DTO, Closure $next): LoginDTO
    {
        $this->lastLoginDataRepository->store(
            $DTO->getUser()->getId(),
            $this->requestService->getIp(),
        );

        return $next($DTO);
    }
}
