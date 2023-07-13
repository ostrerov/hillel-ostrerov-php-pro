<?php

namespace App\Services;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
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
        return $this->bookRepository->getByQuery($query);
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
     * @param  int  $id
     * @return int
     */
    public function destroy(int $id): int
    {
        return $this->bookRepository->destroy($id);
    }
}
