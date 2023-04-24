<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = $this->faker->words(2, true);
        $special_price = $this->faker->optional()->randomFloat(2, 5, 50);

        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'special_price' => $special_price,
            'special_price_from' => isset($special_price) ? $this->faker->dateTimeThisMonth() : null,
            'special_price_to' => isset($special_price) ? $this->faker->dateTimeBetween('now', '+1 month') : null,
            'is_active' => $this->faker->boolean(),
        ];
    }
}
