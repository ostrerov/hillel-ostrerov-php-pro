<?php

namespace App\Repositories\Users;

use App\Repositories\Users\Iterators\UserIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('users');
    }

    public function register(NewUserDTO $DTO): int
    {
        return $this->query->insertGetId([
            'name' => $DTO->getName(),
            'email' => $DTO->getEmail(),
            'password' => Hash::make($DTO->getPassword()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function getUserById(int $id): UserIterator
    {
        return new UserIterator(
            $this->query->where('id', '=', $id)->first()
        );
    }
}
