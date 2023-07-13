<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $year = fake()->dateTimeBetween(1970, date('Y'))->format('Y');
        $createdAt = fake()->dateTimeBetween($year . '-01-01', date('Y-m-d'));

        return [
            'name' => $this->faker->name(),
            'year' => $year,
            'lang' => $this->faker->randomElement(['en', 'ua', 'pl', 'de']),
            'pages' => $this->faker->numberBetween(10, 55000),
            'created_at' => $createdAt,
            'updated_at' => Carbon::now(),
        ];
    }
}
