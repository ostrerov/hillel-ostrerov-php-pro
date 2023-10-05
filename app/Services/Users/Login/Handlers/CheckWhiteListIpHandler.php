<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\WhiteList\WhiteListIpRepository;
use App\Services\RequestService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use Closure;

class CheckWhiteListIpHandler implements LoginInterface
{
    public function __construct(
        protected WhiteListIpRepository $whiteListIpRepository,
        protected RequestService $requestService
    ) {
    }

    /**
     * @param LoginDTO $DTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $DTO, Closure $next): LoginDTO
    {
        $exists = $this->whiteListIpRepository->existByUserIdAndIp(
            $DTO->getUser()->getId(),
            $this->requestService->getIp(),
        );

        if ($exists === false) {
            return $DTO;
        }

        return $next($DTO);
    }
}
