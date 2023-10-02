<?php

namespace Database\Seeders;

use App\Enums\Lang;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    protected Generator $faker;
    protected Builder $table;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
        $this->table = DB::table('books');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 1200000;
        $batchSize = 1000;

        for ($i = 0; $i < $total; $i += $batchSize) {
            $data = [];

            for ($l = 0; $l < $batchSize; $l++) {
                $year = $this->faker->dateTimeBetween(1970)->format('Y');
                $createdAt = $this->faker->dateTimeBetween($year . '-01-01');

                $data[] = [
                    'name' => $this->faker->unique()->sentence(),
                    'year' => $year,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                    'lang' => $this->faker->randomElement(Lang::class),
                    'pages' => fake()->numberBetween(10, 55000),
                    'category_id' => $this->faker->numberBetween(1, 200),
                ];
            }

            DB::table('books')->insert($data);
        }
    }

    /**
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
