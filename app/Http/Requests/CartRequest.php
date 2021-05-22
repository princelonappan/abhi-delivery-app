<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
{
    /**
     * Route endpoint
     * @var string
     */
    protected $endpoint;

    /**
     * HTTP request verb
     * @var string
     */
    protected $verb;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $this->endpoint = $this->path();
        $this->verb = $this->getMethod();

        if($this->verb == 'POST') {
            if($this->endpoint == 'api/v1/cart') {
                $rules = [
                    'customer_id' => 'required|exists:customers,id',
                    'product_id' => 'exists:products,id',
                    'qty' => 'required_with:product_id|numeric',
                    'price' => 'required_with:product_id|numeric',
                ];

            }
        }

        if($this->verb == 'PUT') {
            $rules['operation'] = 'required|in:Add,Update,Delete';
            if($this->operation != 'Add') {
                $rules['product_id'] = 'required|exists:products,id|exists:cart_items,product_id';
            } else {
                $rules['product_id'] = 'required|exists:products,id';
            }
            $rules['qty'] = 'required_with:product_id|numeric';
            $rules['price'] = 'required_with:product_id|numeric';
        }

        if($this->verb == 'POST') {
            if($this->endpoint == 'api/v1/distributor/cart') {
                $rules = [
                    'distributor_id' => 'required|exists:customers,id',
                    'product_id' => 'exists:products,id',
                    'qty' => 'required_with:product_id|numeric',
                    'price' => 'required_with:product_id|numeric',
                ];

            }
        }


        return $rules;
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return  [
            'customer_id.required' => 'The customer id is required',
            'customer_id.exists' => 'The customer doesnt exist',
            'product_id.exists' => 'The product you have selected doesnt exist or not added to the cart yet',
            'qty.required_with' => 'The quantity of the selected product is required',
            'price.required_with' => 'The price of the selected product is required',
            "operation.required" => "Please specify whether you want to add a new item or update or delete an existing item",
            "operation.in" => "Supported operation types are Add, Update or Delete"

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
