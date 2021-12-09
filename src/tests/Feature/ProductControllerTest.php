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
        Product::create($this->product);
        $response = $this->getJson('api/products/1');

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson($this->product);
    }
}
