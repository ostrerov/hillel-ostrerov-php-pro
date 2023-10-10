<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use App\Repositories\Books\Iterators\BooksWithoutJoinsIterator;
use App\Repositories\Categories\Iterators\CategoryIterator;
use App\Repositories\Categories\Iterators\CategoryWithBooksIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('categories');
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $collection = $this->query->get();

        return $collection->map(function (object $item) {
           return new CategoryWithoutBooksIterator($item);
        });
    }

    /**
     * @param  CategoryStoreDTO  $data
     * @return int
     */
    public function store(CategoryStoreDTO $data): int
    {
        return $this->query->insertGetId([
            'name' => $data->getName(),
            'created_at' => Carbon::now()->timezone('Europe/Kyiv'),
        ]);
    }

    /**
     * @param  int  $id
     * @return Model|Builder|null
     */
    public function show(int $id): Model|Builder|null
    {
        return $this->query->where('id', '=', $id)->first();
    }

    /**
     * @param  CategoryUpdateDTO  $data
     * @return int
     */
    public function update(CategoryUpdateDTO $data): int
    {
        $this->query->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);

        return $data->getId();
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->query->where('id', '=', $id)->delete();
    }

    /**
     * @param  int  $id
     * @return CategoryWithoutBooksIterator
     */
    public function getById(int $id): CategoryWithoutBooksIterator
    {
        return new CategoryWithoutBooksIterator(
            $this->query
                ->select([
                    'categories.id',
                    'categories.name',
                    'categories.created_at',
                    'categories.updated_at',
                    'categories.deleted_at'
                ])
                ->where('id', '=', $id)
                ->first()
        );
    }

    public function getByIdIterator(int $id): CategoryWithBooksIterator
    {
        $result = $this->query
            ->select([
                'categories.id as category_id',
                'categories.name as category_name',
                'books.id',
                'books.name',
                'books.year',
                'books.lang',
                'books.pages',
                'books.created_at',
                'books.updated_at',
            ])
            ->join('books', 'categories.id', '=', 'books.category_id')
            ->where('categories.id', '=', $id)
            ->limit(10)
            ->get();

        return new CategoryWithBooksIterator($result);
    }

    public function getByIdModel(int $id): Category
    {
        return Category::query()
            ->with('books', function ($books) {
                return $books->limit(10);
            })
            ->whereId($id)
            ->first();
    }

    /**
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        $limit = 1000000;
        $lastId = 5;

        $collection = DB::table('categories')
            ->select([
                'categories.id',
                'categories.name',
                'categories.created_at',
                'categories.updated_at',
                'categories.deleted_at'
            ])
            ->limit($limit)
            ->where('categories.id', '>', $lastId)
            ->get();

        return $collection->map(function ($items) {
            return new CategoryWithoutBooksIterator($items);
        });
    }
}
