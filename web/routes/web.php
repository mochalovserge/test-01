<?php
use Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/', function () {

    $data = [
        'name' => 'name',
        'phone' => '',
        'address' => '',
    ];


    /** @var  $validator */
    $validator = Validator::make($data, [
        'name' => 'required',
        'address' => 'required|array|min:1',
        'phone' => 'required|array|min:1'
    ]);

     $validator->after(function ($validator) {
        if ($this->somethingElseIsInvalid()) {
            $validator->errors()->add('name', 'Something is wrong with this field!');
        }
    });

    if ($validator->fails()) {
    //    return $validator->errors($data);
    }


    return [
        'message' => 'hello world'
    ];

    //return view('welcome');
});
