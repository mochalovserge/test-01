<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongFieldsException;
use Validator;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class CartController
 * @package App\Http\Controllers
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class CartController extends Controller
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var Product
     */
    protected $product;

    /**
     * CartController constructor.
     *
     * @param Cart $cart
     * @param Product $product
     */
    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }

    /**
     * @return array
     */
    public function getCart()
    {
        return [
            "data" => $this->cart->getCart()
        ];
    }

    /**
     * @param Request $request
     */
    public function addCart(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
            'quantity' => 'required|integer|between:1,10',
        ];

        $messages = [
            'id.required' => [
                'code' => 'required',
                'message' => 'Product cannot be blank.',
                'name' => 'id'
            ],
            'id.integer' => [
                'code' => 'numeric',
                'message' => 'The id must be a number.',
                'name' => 'id'
            ],
            'quantity.required' => [
                'code' => 'required',
                'message' => 'Quantity cannot be blank.',
                'name' => 'quantity'
            ],
            'quantity.integer' => [
                'code' => 'integer',
                'message' => 'The quantity must be a number.',
                'name' => 'quantity'
            ],
            'quantity.between' => [
                'code' => 'between',
                'message' => 'The quantity value is not between :min - :max.',
                'name' => 'quantity'
            ],
        ];

        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($request->all(), $rules, $messages);
        $this->validateProductExists($validator, $request->input('id'));

        if ($validator->fails()) {
            throw new WrongFieldsException(null, $validator->errors());
        }

        $this->cart->add($request->input('id'), $request->input('quantity'));
    }

    /**
     * @param int $product_id
     */
    public function delCart($product_id)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make(['product_id' => $product_id], []);
        $this->validateProductExists($validator, $product_id);

        if ($validator->fails()) {
            throw new WrongFieldsException(null, $validator->errors());
        }

        $this->cart->delete($product_id);
    }

    /**
     * @param $validator
     * @param $product_id
     */
    private function validateProductExists($validator, $product_id)
    {
        $validator->after(function ($validator) use ($product_id) {
            if (!$this->product->getProduct($product_id)) {
                $validator->errors()->add('product_id', [
                    'code' => 'exists',
                    'message' => 'Такого продукта нет в системе.',
                    'name' => 'product_id',
                ]);
            }
        });
    }
}
