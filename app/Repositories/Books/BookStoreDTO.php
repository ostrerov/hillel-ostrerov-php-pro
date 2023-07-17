<?php

namespace App\Repositories\Books;

class BookStoreDTO
{

    /**
     * @param  string  $name
     * @param  int  $year
     * @param  string  $lang
     * @param  int  $pages
     * @param  int  $categoryId
     */
    public function __construct(
        protected string $name,
        protected int $year,
        protected string $lang,
        protected int $pages,
        protected int $categoryId
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
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
