<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            $rules = [
                'cart_id' => [
                    'required',
                    Rule::exists('carts', 'id')->where(function($query) {
                        return $query->where('status', 'Active');
                    })
                ],
                'order_total' => 'required|numeric',
                'address' => 'required',
                'address_type' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'country' => 'required'
            ];
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
            'cart_id.required' => 'Cart is required',
            'cart_id.exists' => 'The cart you are trying to checkout doesnt exist or not Active',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
