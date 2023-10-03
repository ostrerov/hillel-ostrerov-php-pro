<?php

namespace App\Services\Users;

class UserAuthService
{
    public function authCheck(): bool
    {
        return auth('api')->check();
    }

    public function authAttempt(array $data): bool
    {
        if (auth()->attempt($data) === true) {
            return true;
        }

        return false;
    }

    public function createUserToken()
    {
        return auth()->user()->createToken(config('app.name'));
    }

    public function getUserId(): int
    {
        return auth()->id();
    }

    public function revokeAuthToken(): void
    {
        auth('api')->user()->token()->revoke();
    }
}
