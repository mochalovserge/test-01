<?php

namespace Tests\Feature;

use App\Cart;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    /**
     * Test cart feature
     */
    public function testProductsCountAndTotalSum()
    {
        $products = new Product();
        $cart = new Cart($products);

        $cart->add(1, 2);
        $cart->add(2, 3);
        $cart->add(3, 1);

        $this->assertEquals($cart->getProductsCount(), 6);
        $this->assertEquals($cart->getTotalSum(), 835.85);

        $cart->delete(3);

        $this->assertEquals($cart->getProductsCount(), 5);
        $this->assertEquals($cart->getTotalSum(), 578.95);

        $cart->delete(1);
        $cart->delete(1);

        $this->assertEquals($cart->getProductsCount(), 3);
    }
}
