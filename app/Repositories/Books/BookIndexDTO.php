<?php

namespace App\Repositories\Books;

class BookIndexDTO
{
    /**
     * @param  string  $startDate
     * @param  string  $endDate
     * @param  int|null  $year
     * @param  string|null  $lang
     */
    public function __construct(
        protected string $startDate,
        protected string $endDate,
        protected int|null $year = null,
        protected string|null $lang = null,
    ) {
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {
        return $this->lang;
    }
}
