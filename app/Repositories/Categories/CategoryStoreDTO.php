<?php

namespace App\Repositories\Categories;

class CategoryStoreDTO
{
    /**
     * @param  string  $name
     */
    public function __construct(
        protected string $name,
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
