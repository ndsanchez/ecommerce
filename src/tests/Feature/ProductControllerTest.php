<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public $product = [
        'name' => 'Rice 1 kg',
        'price' => 3000
    ];

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
        
        $response = $this->postJson('/api/products', $this->product);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson($this->product);
    }

    /**
     * test show method
     * 
     * @return void
     */
    public function test_show()
    {
        $product = Product::create($this->product);
        $response = $this->getJson("api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson($this->product);
    }

    /**
     * test update method
     * 
     * @return void
     */
    public function test_update()
    {
        $product = Product::factory()->create();
        $newProduct = [
            'name' => 'Bread',
            'price' => 2000
        ];

        $response = $this->putJson("api/products/{$product->getKey()}", $newProduct);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $newProduct);
        $response->assertJson($newProduct);
    }

    /**
     * test destroy method
     * 
     * @return void
     */
    public function test_destroy()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("api/products/{$product->getKey()}");
        $response->assertSuccessful(200);
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
