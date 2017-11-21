<?php

namespace App\Http\Controllers;

use Validator;

/**
 * Class ProductController
 * @package App\Http\Controllers
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class ProductController extends Controller
{
    /**
     * Get products
     */
    public function products()
    {
        $data = [
            'name' => '',
            'phone' => 'sdff',
            'address' => '',
        ];

        $rules = [
            'name' => 'required',
            'phone' => 'required|min:20|max:255|email',
            'address' => 'required|integer',
        ];

        $messages = [
            'name.required' => ["message"=>'please fill Base Size field', 'code'=>"reqiuirr", "name"=> "phone"],
            'phone.required' => ["message"=>'please fill Base Size field', 'code'=>"reqiuirr", "name"=> "phone"],
            'phone.min' => ["message"=>'min', 'code'=>"reqiuirr", "name"=> "phone"],
            'phone.max' => ["message"=>'max', 'code'=>"reqiuirr", "name"=> "phone"],
            'phone.email' => ["message"=>'email', 'code'=>"reqiuirr", "name"=> "phone"],
        ];


        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {

            $errors_vals = [];
            foreach ($validator->errors()->toArray() as $errors) {
                foreach ($errors as $error) {
                    $errors_vals[] = $error;
                }
            }

            return [
                'errors' => $errors_vals
            ];
        }

        return [
            'data' => []
        ];
    }
}
