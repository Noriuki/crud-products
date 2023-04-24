<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    protected $model = CategoryProduct::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
