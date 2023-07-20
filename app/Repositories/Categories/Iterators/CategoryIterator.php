<?php

namespace App\Repositories\Categories\Iterators;

class CategoryIterator
{
    protected int $id;
    protected string $name;
    protected string|null $createdAt;
    protected string|null $updatedAt;
    protected string|null $deletedAt;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
        $this->deletedAt = $data->deleted_at;
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

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

}
