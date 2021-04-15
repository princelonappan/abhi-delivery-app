<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRequest extends FormRequest
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
            if($this->endpoint == 'api/v1/customer/register') {
                $rules = [
                    'name' => 'required',
                    'phone_number' => 'required|unique:customers,phone_number,NULL,id|digits:10',
                    'email' => 'email|unique:users,email,NULL,id',
                    'date_of_birth' => 'required|date',
                    'password' => 'required|confirmed|regex:/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#@$?]*[!#@$?]).{8,}$/'//Min 8 chars, atleast one lower case, one upper case and a number with atleast one specal char($ or @)
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
            'name.required' => 'The customer name is required',
            'phone_number.required'  => 'The customer phone number is required',
            'phone_number.unique'  => 'The customer phone number must be unique',
            'phone_number.digits' => 'The customer phone number doesnt have 10 digits',
            'password.required' => 'A password is required',
            'password.confirmed' => 'Password and confirm password doesnt match',
            'password.regex' => 'Password must be atleast 8 chars in length with atleat one upper case letter,
                                one lower case letter, one number and one specal char(!,@,#,$)'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
