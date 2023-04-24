<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_should_create_a_product(): void
    {
        // ARRANGE
        $data = [
            'name' => 'produto-mock-1',
            'slug' => 'produto-mock-1',
            'price' => $this->faker->randomFloat(2, 10, 100),
            'special_price' => null,
            'special_price_from' =>  null,
            'special_price_to' => null,
            'is_active' => 1,
        ];
        // ACT
        $response = $this->postJson('/api/products', $data);

        // ASSERT
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price']
        ]);
    }

    /** @test */
    public function it_should_fail_create_a_duplicate_product(): void
    {
        // ARRANGE
        $product_1 = Product::factory()->create();

        $data = [
            'name' => $product_1->name,
            'slug' => $product_1->slug,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'special_price' => null,
            'special_price_from' =>  null,
            'special_price_to' => null,
            'is_active' => 1,
        ];
        // ACT
        $response = $this->postJson('/api/products', $data);

        // ASSERT
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);

        $this->assertDatabaseMissing('products', [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price']
        ]);
    }

    /** @test */
    public function it_should_list_available_products(): void
    {
        // ARRANGE
        Product::factory()->state([
            'is_active' => 1,
        ])->count(5)->create();

        Product::factory()->state([
            'is_active' => 1,
        ])->trashed()->create();

        // ACT
        $response = $this->getJson('/api/products');

        // ASSERT
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    /** @test */
    public function it_should_get_a_product_by_slug(): void
    {
        // ARRANGE
        Product::factory()->state([
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 10.99
        ])->create();
        $slug = 'test-product-1';

        // ACT
        $response = $this->getJson("/api/products/{$slug}");

        // ASSERT
        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 10.99
        ]);
    }

    /** @test */
    public function it_should_fail_get_a_product_by_slug(): void
    {
        // ARRANGE
        Product::factory()->state([
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 10.99
        ])->create();
        $slug = 'test-product-2';

        // ACT
        $response = $this->getJson("/api/products/{$slug}");

        // ASSERT
        $response->assertStatus(404);
        $response->assertJsonCount(0);
    }

    /** @test */
    public function it_should_update_a_product(): void
    {
        // ARRANGE
        $product_1 = Product::factory()->state([
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 10.99
        ])->create();

        $data = [
            'price' => 15.90
        ];
        // ACT
        $response = $this->putJson("/api/products/{$product_1->id}", $data);

        // ASSERT
        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => 'Test Product 1',
            'slug' => 'test-product-1',
            'price' => 15.90
        ]);
    }

    /** @test */
    public function it_should_delete_a_product_by_id(): void
    {
        // ARRANGE
        $product_1 = Product::factory()->create();

        // ACT
        $response = $this->deleteJson("/api/products/{$product_1->id}");

        // ASSERT
        $response->assertStatus(200);
        $this->assertSoftDeleted('products', [
            'name' => $product_1->name,
            'slug' => $product_1->slug,
            'price' => $product_1->price,
        ]);
    }
}
