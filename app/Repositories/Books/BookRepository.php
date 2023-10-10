<?php

namespace App\Repositories\Books;

use App\Models\Book;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Repositories\Books\Iterators\BookWithoutAuthorsIterator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('books');
    }

    /**
     * @param BookIndexDTO $data
     * @return Builder
     */
    public function index(BookIndexDTO $data): Builder
    {
        $this->query->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'books.pages',
                'books.created_at',
                'category_id',
                'categories.name as category_name'
            ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit(10)
            ->where('books.id', '>', $data->getLastId());

        return $this->query;
    }

    /**
     * @param BookStoreDTO $data
     * @return int
     */
    public function store(BookStoreDTO $data): int
    {
        return DB::table('books')->insertGetId([
            'name' => $data->getName(),
            'year' => $data->getYear(),
            'lang' => $data->getLang(),
            'pages' => $data->getPages(),
            'category_id' => $data->getCategoryId(),
            'created_at' => Carbon::now()->timezone('Europe/Kyiv')
        ]);
    }

    /**
     * @param int $id
     * @return Model|Builder|null
     */
    public function show(int $id): Model|Builder|null
    {
        return DB::table('books')->where('id', '=', $id)->first();
    }

    /**
     * @param BookUpdateDTO $data
     * @return int
     */
    public function update(BookUpdateDTO $data): int
    {
        return DB::table('books')
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'year' => $data->getYear(),
                'lang' => $data->getLang(),
                'pages' => $data->getPages(),
                'category_id' => $data->getCategoryId(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        DB::table('books')->where('id', '=', $id)->delete();
    }

    /**
     * @param int $id
     * @return BookWithoutAuthorsIterator
     */
    public function getById(int $id): BookWithoutAuthorsIterator
    {
        $bookQuery = $this->query
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'books.pages',
                'books.created_at',
                'category_id',
                'categories.name as category_name'
            ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->where('books.id', '=', $id)
            ->first();

        return new BookWithoutAuthorsIterator((object)[
            'id'            => $bookQuery->id,
            'name'          => $bookQuery->name,
            'year'          => $bookQuery->year,
            'category'      => (object)[
                'id'        => $bookQuery->category_id,
                'name'      => $bookQuery->category_name,
            ],
            'lang'          => $bookQuery->lang,
            'pages'         => $bookQuery->pages,
            'created_at'    => $bookQuery->created_at,
        ]);
    }

    /**
     * @param int $lastId
     * @return BooksIterator
     */
    public function getDataByIterator(int $lastId = 0): BooksIterator
    {
        $result = $this->query
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
                'books.created_at',
                'books.updated_at',
                'authors.id as author_id',
                'authors.name as author_name',
            ])
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->join('author_book', 'books.id', '=', 'author_book.book_id')
            ->join('authors', 'author_book.author_id', '=', 'authors.id')
            ->orderBy('books.id')
            ->where('books.id', '>', $lastId)
            ->limit(2000)
            ->get();

        return new BooksIterator($result);
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getDataByModel(int $lastId = 0): Collection
    {
        return Book::query()
            ->with(['authors', 'category'])
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->limit(2000)
            ->get();
    }

    /**
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        $lastId = 1;
        $collection = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'books.created_at',
                'category_id',
                'categories.name as category_name',
            ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit(2)
            ->where('books.id', '>', $lastId)
            ->get();

        return $collection->map(function ($item) {
            return new BookWithoutAuthorsIterator(
                (object)[
                'id'            => $item->id,
                'name'          => $item->name,
                'year'          => $item->year,
                'category'      => (object)[
                    'id'        => $item->category_id,
                    'name'      => $item->category_name,
                ],
                'lang'          => $item->lang,
                'pages'         => $item->pages,
                'created_at'    => $item->created_at,
            ]);
        });
    }

    public function filterByCreatedAt(string $startDate, string $endDate): Builder
    {
        return $this->query->where('books.created_at', '>=', $startDate)
            ->where('books.created_at', '<=', $endDate);
    }

    public function useCreatedAtIndex(): Builder
    {
        return $this->query->useIndex('books_created_at_index');
    }
}
