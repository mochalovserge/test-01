<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Validator;

/**
 * Class ProductController
 * @package App\Http\Controllers
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class ProductController extends Controller
{
    /**
     * @param Product $product
     * @return array
     */
    public function products(Product $product)
    {
        return [
            'data' => $product->getProducts()
        ];
    }

    /**
     * @param int $product_id
     * @param Product $product
     * @return array
     */
    public function product($product_id, Product $product)
    {
        return [
            'data' => $product->getProduct($product_id)
        ];
    }
}
