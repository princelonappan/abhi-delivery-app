<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DistributorRequest extends FormRequest
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
        if($this->verb == 'POST') {
            if($this->endpoint == 'api/v1/distributor/store') {
                $rules = [
                    'phone_number' => 'required|exists:distributors,phone_number|digits:10',
                    'password' => 'required'
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
        return [
            'phone_number.required'  => 'The distributor phone number is required',
            'phone_number.unique'  => 'The distributor phone number must be unique',
            'phone_number.digits' => 'The distributor phone number doesnt have 10 digits',
            'phone_number.exists'  => 'The distributor phone number doesnt exist',
            'password.required' => 'A password is required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
