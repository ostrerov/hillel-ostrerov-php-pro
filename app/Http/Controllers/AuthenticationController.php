<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\NewUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Users\NewUserDTO;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginService;
use App\Services\Users\UserAuthService;
use App\Services\Users\UserRegisterService;
use App\Services\Users\UserService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    public function __construct(
        protected UserAuthService $userAuthService,
    ) {
    }

    /**
     * @param NewUserRequest $request
     * @param UserRegisterService $registerService
     * @return JsonResponse
     */
    public function register(NewUserRequest $request, UserRegisterService $registerService): JsonResponse
    {
        $DTO = new NewUserDTO(...$request->validated());
        $service = $registerService->register($DTO);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return Application|Response|JsonResponse
     */
    public function login(LoginRequest $request, LoginService $loginService): Application|Response|JsonResponse
    {
        $data = $request->validated();
        $DTO = new LoginDTO(...$data);
        $user = $loginService->handle($DTO);

        $resource = new UserResource($user->getUser());
        $bearerToken = $user->getBearerToken();

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    /**
     * @param UserService $userService
     * @return JsonResponse
     */
    public function profile(UserService $userService): JsonResponse
    {
        $user = $userService->getById(
            $this->userAuthService->getUserId()
        );
        $resource = new UserResource($user);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->userAuthService->revokeAuthToken();

        return response()->json(['message' => 'User was logged out.'])
            ->setStatusCode(200);
    }
}
