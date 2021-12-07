<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    /**
     * Test index method
     *
     * @return void
     */
    public function test_index()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5);
    }

    /**
     * test store method
     * 
     * @return void
     * 
    */
    public function test_store()
    {
        $product = [
            'name' => 'Rice 1 kg',
            'price' => 3000
        ];
        $response = $this->postJson('/api/products', $product);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson($product);
    }
}
