<?php

namespace App\Repositories\Books;

use App\Enums\Lang;

class BookStoreDTO
{

    /**
     * @param string $name
     * @param int $year
     * @param Lang $lang
     * @param int $pages
     * @param int $categoryId
     * @param ?int $authorId
     */
    public function __construct(
        protected string $name,
        protected int $year,
        protected Lang $lang,
        protected int $pages,
        protected int $categoryId,
        protected ?int $authorId = null,
    ) {
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
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }
}
