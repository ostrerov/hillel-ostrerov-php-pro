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
    /**
     * @param  BookIndexDTO  $data
     * @return Collection
     */
    public function index(BookIndexDTO $data): Collection
    {
        $query = DB::table('books')
            ->whereBetween('created_at', [
                $data->getStartDate(),
                $data->getEndDate()
            ]);

        if (is_null($data->getYear()) === false) {
            $query->where('year', '=', $data->getYear());
        }

        if (is_null($data->getLang()) === false) {
            $query->where('lang', '=', $data->getLang());
        }

        return $query->get();
    }

    /**
     * @param  BookStoreDTO  $data
     * @return int
     */
    public function store(BookStoreDTO $data): int
    {
        return DB::table('books')->insertGetId([
            'name' => $data->getName(),
            'year' => $data->getYear(),
            'lang' => $data->getLang(),
            'pages' => $data->getPages(),
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
     * @param  BookUpdateDTO  $data
     * @return int
     */
    public function update(BookUpdateDTO $data): int
    {
        DB::table('books')
            ->where('id', '=', $data->getId())
            ->update([
                'name' => $data->getName(),
                'year' => $data->getYear(),
                'lang' => $data->getLang(),
                'pages' => $data->getPages(),
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
     * @return BookIterator
     */
    public function getById(int $id): BookIterator
    {
        return new BookIterator(
            DB::table('books')
                ->where('id', '=', $id)
                ->first()
        );
    }

    /**
     * @param  Collection  $query
     * @return Collection
     */
    public function getByQuery(Collection $query): Collection
    {
        return $query->map(function ($query) {
            return new BookIterator($query);
        });
    }
}
