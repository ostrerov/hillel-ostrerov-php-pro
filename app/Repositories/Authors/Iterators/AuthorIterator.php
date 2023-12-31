<?php

namespace App\Repositories\Authors\Iterators;

class AuthorIterator
{
    protected int $id;
    protected string $name;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id   = $data->id;
        $this->name = $data->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
