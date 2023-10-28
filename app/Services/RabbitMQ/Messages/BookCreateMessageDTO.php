<?php

namespace App\Services\RabbitMQ\Messages;

use App\Enums\Lang;
use JsonSerializable;

class BookCreateMessageDTO implements JsonSerializable
{
    protected string $name;
    protected int $year;
    protected Lang $lang;
    protected int $pages;
    protected int $categoryId;
    protected int $authorId;

    public function __construct(object $data)
    {
        $this->name         = $data->name;
        $this->year         = $data->year;
        $this->lang         = Lang::from($data->lang);
        $this->pages        = $data->pages;
        $this->categoryId   = $data->categoryId;
        $this->authorId     = $data->authorId;
    }

    public function jsonSerialize(): array
    {
        return [
            'name'          => $this->name,
            'year'          => $this->year,
            'lang'          => $this->lang,
            'pages'         => $this->pages,
            'categoryId'    => $this->categoryId,
            'authorId'      => $this->authorId,
        ];
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

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}
