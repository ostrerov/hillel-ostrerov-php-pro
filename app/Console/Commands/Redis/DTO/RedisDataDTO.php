<?php

namespace App\Console\Commands\Redis\DTO;

class RedisDataDTO
{
    public function __construct(
        protected int $id,
        protected string $name,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
