<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $year = fake()->dateTimeBetween(1970)->format('Y');
        $createdAt = fake()->dateTimeBetween($year . '-01-01');
        $categoryId = Category::pluck('categories.id')->toArray();
        $categoryIdItem = $this->faker->randomElement($categoryId);

        return [
            'name' => $this->faker->name() . ' (' . $this->faker->numberBetween(10, 55000) . ')',
            'year' => $year,
            'lang' => $this->faker->randomElement(['en', 'ua', 'pl', 'de']),
            'pages' => $this->faker->numberBetween(10, 55000),
            'created_at' => $createdAt,
            'updated_at' => NULL,
            'category_id' => is_null($categoryIdItem) === false ? $categoryIdItem : Category::factory(200)->create()->first()
        ];
    }
}
