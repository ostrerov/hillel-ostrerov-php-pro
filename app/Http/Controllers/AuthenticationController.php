<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\NewUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Users\NewUserDTO;
use App\Services\Users\UserAuthService;
use App\Services\Users\UserLoginService;
use App\Services\Users\UserRegisterService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    public function __construct(
        protected UserRegisterService $userRegisterService,
        protected UserAuthService $userAuthService,
        protected UserLoginService $userLoginService,
    ) {
    }

    /**
     * @param NewUserRequest $request
     * @return JsonResponse
     */
    public function register(NewUserRequest $request): JsonResponse
    {
        $DTO = new NewUserDTO(...$request->validated());
        $service = $this->userRegisterService->register($DTO);
        $resource = new UserResource($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param LoginRequest $request
     * @return Application|Response|JsonResponse
     */
    public function login(LoginRequest $request): Application|Response|JsonResponse
    {
        $data = $request->validated();
        $user = $this->userLoginService->login($data);

        if (is_null($user) === true) {
            return response(['error' => 'Credentials has not match']);
        }

        $bearerToken = $this->userAuthService->createUserToken();
        $resource = new UserResource($user);

        return $resource->additional([
            'Bearer' => $bearerToken,
        ])->response()->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        $user = $this->userLoginService->getUserById(
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
