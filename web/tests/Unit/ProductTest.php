<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

    /**
     * Test get product by id
     */
    public function testTakeOne()
    {
        $products = new Product();

        $this->assertEquals([
            'id' => 1,
            'name' => 'Product #1',
            'description' => 'Product description',
            'price' => 55.25
        ], $products->getProduct(1));
    }

    /**
     * Test get all products
     */
    public function testHasProducts() {
        $products = new Product();

        $this->assertNotEmpty($products->getProducts());
    }
}
