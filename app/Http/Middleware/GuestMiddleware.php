<?php

namespace App\Http\Middleware;

use App\Services\Users\UserAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{

    public function __construct(
        protected UserAuthService $userAuthService,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->userAuthService->authCheck() === false) {
            return $next($request);
        }

        return response()->json(['message' => 'You are logged in already'])->setStatusCode(200);
    }
}
