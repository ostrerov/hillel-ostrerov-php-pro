<?php

namespace App\Repositories\Books\Iterators;

use App\Repositories\Categories\Iterators\CategoryIterator;

class BookIterator
{
    protected int $id;
    protected CategoryIterator $category;
    protected string $name;
    protected int $year;
    protected string $lang;
    protected int $pages;
    protected string|null $createdAt;
    protected string|null $updatedAt;
    protected string|null $deletedAt;

    /**
     * @param  object  $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->category = new CategoryIterator(
            $data->category_id,
            $data->category_name
        );
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = $data->lang;
        $this->pages = $data->pages;
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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
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

    /**
     * @return CategoryIterator
     */
    public function getCategory(): CategoryIterator
    {
        return $this->category;
    }
}
