<?php

namespace App\Repositories\AuthorBook;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class AuthorBookRepository
{
    protected Builder $query;
    public function __construct()
    {
        $this->query = DB::table('author_book');
    }

    public function joinAuthorToBook(int $bookId, int $authorId): bool
    {
        return $this->query->insert([
            'author_id' => $authorId,
            'book_id' => $bookId,
        ]);
    }
}
