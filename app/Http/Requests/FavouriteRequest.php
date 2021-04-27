<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class FavouriteRequest extends FormRequest
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
                'customer_id' => 'required|numeric',
                'product_id' => 'required|numeric',
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
            'customer_id.required' => 'Customer id is required',
            'product_id.required' => 'Product id is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
