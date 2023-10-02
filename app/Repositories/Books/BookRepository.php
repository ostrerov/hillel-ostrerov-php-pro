<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
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
     * @return BookIterator
     */
    public function getById(int $id): BookIterator
    {
        return new BookIterator(
            DB::table('books')
                ->select([
                    'books.id',
                    'books.name',
                    'books.year',
                    'books.lang',
                    'books.pages',
                    'books.created_at',
                    'books.category_id',
                    'categories.name as category_name',
                    'books.created_at',
                    'books.updated_at',
                    'books.deleted_at'
                ])
                ->join('categories', 'categories.id', '=', 'books.category_id')
                ->where('books.id', '=', $id)
                ->first()
        );
    }

    /**
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        $max = 10000000;
        $collection = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'books.created_at',
                'category_id',
                'categories.name as category_name',
            ])
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit(2)
            ->where('books.id', '>', $max)
            ->get();

        return $collection->map(function ($item) {
            return new BookIterator($item);
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
