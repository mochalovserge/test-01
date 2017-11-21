<?php

namespace App;

use Validator;
use App\Models\Product;

/**
 * Class Cart
 * @package App
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class Cart
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $products;

    /**
     * @var float
     */
    protected $products_count = 0;

    /**
     * @var float
     */
    protected $total_sum = 0;


    /**
     * Cart constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->products = collect();
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function search($id)
    {
        return $this->products->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });
    }

    public function add($product_id, $quantity)
    {
        $product = $this->product->getProduct($product_id);

        $this->products = session('cart', collect());
        $key = $this->search($product_id);

        if (is_numeric($key)) {
            $item = $this->products->pull($key);
            if (!is_null($item)) {
                $item['quantity'] += $quantity;
                $item['sum'] = round($product['price'] * $item['quantity'], 2);

                $this->products->put($key, $item);
            }
        } else {
            $this->products->push([
                'id' => $product_id,
                'quantity' => $quantity,
                'sum' => round($product['price'] * $quantity, 2),
            ]);
        }

        session(['cart' => $this->products]);
    }

    /**
     * Get all cart data
     *
     * @return array
     */
    public function getCart()
    {
        $this->products = session('cart', collect());

        $this->total_sum = round($this->products->sum('sum'), 2);
        $this->products_count = $this->products->sum('quantity');

        return [
            'total_sum' => $this->total_sum,
            'products_count' => $this->products_count,
            'products' => array_values($this->products->toArray())
        ];
    }

    /**
     * @param int $product_id
     */
    public function delete($product_id)
    {
        $product = $this->product->getProduct($product_id);

        $this->products = session('cart', collect());
        $key = $this->search($product_id);

        if (is_numeric($key)) {
            $item = $this->products->pull($key);
            if (!is_null($item)) {
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                    $item['sum'] = round($product['price'] * $item['quantity'], 2);
                    $this->products->put($key, $item);
                } else {
                    $this->products->forget($key);
                }
            }

            session(['cart' => $this->products]);
        }
    }
}