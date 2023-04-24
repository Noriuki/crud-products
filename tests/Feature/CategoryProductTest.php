<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_should_get_a_product_with_category(): void
    {
        // ARRANGE
        $product_with_category_1 = CategoryProduct::factory()->create();
        $category_1 = Category::where('id', $product_with_category_1->category_id)->first();
        $product_1 = Product::where('id', $product_with_category_1->product_id)->first();

        // ACT
        $response = $this->getJson("/api/products/{$product_1->slug}");

        // ASSERT
        $response->assertStatus(200);
        $this->assertEquals(1, count($response['categories']));
        $this->assertEquals($category_1->slug, $response['categories'][0]['slug']);
    }
}
