<?php

namespace App\Models;

/**
 * Class Product
 * @package App\Models
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class Product
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $products;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->products = collect([
            [
                'id' => 1,
                'name' => 'Product #1',
                'description' => 'Product description',
                'price' => 55.25
            ],
            [
                'id' => 2,
                'name' => 'Product #2',
                'description' => 'Product description',
                'price' => 156.15
            ],
            [
                'id' => 3,
                'name' => 'Product #3',
                'description' => 'Product description',
                'price' => 256.9
            ],
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param int $product_id
     * @return mixed
     */
    public function getProduct($product_id)
    {
        $product = $this->products->first(function ($item) use ($product_id) {
            return $item['id'] == $product_id;
        });

        return $product;
    }
}
