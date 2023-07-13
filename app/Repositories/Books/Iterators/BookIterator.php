<?php

namespace App\Repositories\Books\Iterators;

use Carbon\Carbon;

class BookIterator
{
    public int $id;
    public string $name;
    public int $year;
    public string $lang;
    public int $pages;
    public $created_at;
    public $updated_at;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = $data->lang;
        $this->pages = $data->pages;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
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
}
