<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class CartController extends Controller
{
    /**
     * @return array
     */
    public function getCart()
    {
        return [
            "data" => []
        ];
    }

    /**
     * Add to cart
     */
    public function addCart(Request $request)
    {
    }

    /**
     * @param int $product_id
     */
    public function delCart($product_id)
    {

    }
}
