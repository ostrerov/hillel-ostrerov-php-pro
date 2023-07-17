<?php

namespace App\Repositories\Categories;

use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $collection = DB::table('categories')->get();

        return $collection->map(function (object $item) {
           return new CategoryIterator($item->id, $item->name);
        });
    }

    /**
     * @param  CategoryStoreDTO  $data
     * @return int
     */
    public function store(CategoryStoreDTO $data): int
    {
        return DB::table('books')->insertGetId([
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
        return DB::table('books')->where('id', '=', $id)->first();
    }

    /**
     * @param  CategoryUpdateDTO  $data
     * @return int
     */
    public function update(CategoryUpdateDTO $data): int
    {
        DB::table('books')
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'updated_at' => Carbon::now()->timezone('Europe/Kyiv'),
            ]);

        return $data->getId();
    }

    /**
     * @param  int  $id
     * @return int
     */
    public function destroy(int $id): void
    {
        DB::table('books')->where('id', '=', $id)->delete();
    }

    /**
     * @param  int  $id
     * @return CategoryIterator
     */
    public function getById(int $id): CategoryIterator
    {
        return new CategoryIterator(
            DB::table('books')
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

    /**
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        $max = 100000;
        $collection = DB::table('categories')
            ->select([
                'categories.id',
                'categories.name',
                'categories.created_at',
                'categories.updated_at',
                'categories.deleted_at'
            ])
            ->limit($max)
            ->where('categories.id', '>', $max)
            ->get();

        return $collection->map(function ($items) {
            return new CategoryIterator($items);
        });
    }
}
