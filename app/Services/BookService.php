<?php

namespace App\Services;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class BookService
{
    /**
     * @param  BookRepository  $bookRepository
     */
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }

    /**
     * @param  BookIndexDTO  $data
     * @return Collection
     */
    public function index(BookIndexDTO $data): Collection
    {
        $query = $this->bookRepository->index($data);

        $this->getYearQuery($query, $data);

        $this->getLangQuery($query, $data);

        $this->getCreatedAtQuery($query, $data);

        $collection = $query->get();

        return $collection->map(function ($book) {
            return new BookIterator((object)[
                'id'            => $book->id,
                'name'          => $book->name,
                'year'          => $book->year,
                'category'      => (object)[
                    'id'        => $book->category_id,
                    'name'      => $book->category_name,
                ],
                'lang'          => $book->lang,
                'pages'         => $book->pages,
                'created_at'    => $book->created_at,
            ]);
        });
    }

    /**
     * @param  BookStoreDTO  $data
     * @return BookIterator
     */
    public function store(BookStoreDTO $data): BookIterator
    {
        $bookId = $this->bookRepository->store($data);
        return $this->bookRepository->getById($bookId);
    }

    /**
     * @param  int  $id
     * @return BookIterator
     */
    public function show(int $id): BookIterator
    {
        return $this->bookRepository->getById($id);
    }

    /**
     * @param  BookUpdateDTO  $data
     * @return BookIterator
     */
    public function update(BookUpdateDTO $data): BookIterator
    {
        $bookId = $this->bookRepository->update($data);
        return $this->bookRepository->getById($bookId);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->bookRepository->destroy($id);
    }

    /**
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        return $this->bookRepository->getAllBooks();
    }

    /**
     * @param Builder $query
     * @param BookIndexDTO $data
     * @return void
     */
    private function getYearQuery(Builder $query, BookIndexDTO $data): void
    {
        if (is_null($data->getYear()) === false) {
            $query->where('year', '=', $data->getYear());
        }
    }

    /**
     * @param Builder $query
     * @param BookIndexDTO $data
     * @return void
     */
    private function getLangQuery(Builder $query, BookIndexDTO $data): void
    {
        if (is_null($data->getLang()) === false) {
            $query->where('lang', '=', $data->getLang());
        }
    }

    /**
     * @param Builder $query
     * @param BookIndexDTO $data
     * @return void
     */
    private function getCreatedAtQuery(Builder $query, BookIndexDTO $data): void
    {
        $query->where('books.created_at', '>=', $data->getStartDate())
            ->where('books.created_at', '<=', $data->getEndDate());

        if (is_null($data->getYear()) === true && is_null($data->getLang()) === true) {
            $query->useIndex('books_created_at_index');
        }
    }
}
