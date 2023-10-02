<?php

namespace App\Repositories\Books\Iterators;

use App\Enums\Lang;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;

class BookIterator
{
    protected int $id;
    protected CategoryIterator $category;
    protected string $name;
    protected int $year;
    protected Lang $lang;
    protected int $pages;
    protected Carbon $createdAt;
    protected Carbon $updatedAt;
    protected Carbon $deletedAt;

    /**
     * @param  object  $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->category = new CategoryIterator($data->category);
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = Lang::from($data->lang);
        $this->pages = $data->pages;
        $this->createdAt = new Carbon($data->created_at);
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
     * @return Lang
     */
    public function getLang(): Lang
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
     * @return CategoryIterator
     */
    public function getCategory(): CategoryIterator
    {
        return $this->category;
    }
}
