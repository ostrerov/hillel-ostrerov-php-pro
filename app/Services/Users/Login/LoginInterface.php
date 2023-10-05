<?php

namespace App\Services\Users\Login;

use Closure;

interface LoginInterface
{
    /**
     * @param LoginDTO $DTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $DTO, Closure $next): LoginDTO;
}
