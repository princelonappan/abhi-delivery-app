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
                    'phone_number' => 'required|unique:customers,phone_number,NULL,id',
                    'email' => 'email|unique:users,email,NULL,id',
                    'date_of_birth' => 'required|date',
                    'password' => 'required|confirmed|regex:/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#@$?]*[!#@$?]).{8,}$/'
                ];

            }
            if($this->endpoint == 'api/v1/customer/login') {
                $rules = [
                    'type' => 'required|in:phone,facebook,google',
                    'phone_number' => 'required_if:type,phone|exists:customers,phone_number',
                    'password' => 'required_if:type,phone',
                    'facebook_id' => 'required_if:type,facebook',
                    'google_id' => 'required_if:type,google'
                ];

            }
            if ($this->endpoint == 'api/v1/customer/generate-otp') {
                $rules = [
                    'name' => 'required',
                    'phone_number' => 'required|unique:customers,phone_number,NULL,id',
                    'email' => 'email|unique:users,email,NULL,id',
                    'date_of_birth' => 'required|date',
                    'password' => 'required|confirmed|regex:/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#@$?]*[!#@$?]).{8,}$/'//Min 8 chars, atleast one lower case, one upper case and a number with atleast one specal char($ or @)
                ];

            }

            if ($this->endpoint == 'api/v1/customer/update-email') {
                $rules = [
                    'email' => 'email|unique:users,email,NULL,id',
                    'customer_id' => 'required',
                ];

            }

            if ($this->endpoint == 'api/v1/customer/update-phone') {
                $rules = [
                    'phone_number' => 'required|unique:customers,phone_number,NULL,id',
                    'customer_id' => 'required',
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
            'phone_number.required_if'  => 'The customer phone number is required',
            'phone_number.unique'  => 'The customer phone number must be unique',
            'phone_number.digits' => 'The customer phone number doesnt have 10 digits',
            'phone_number.exists'  => 'The customer phone number doesnt exist',
            'password.required' => 'A password is required',
            'password.confirmed' => 'Password and confirm password doesnt match',
            'password.regex' => 'Password must be atleast 8 chars in length with atleat one upper case letter, one lower case letter, one number and one specal char(!,@,#,$)',
            'type.in' => 'Only Phone, Facebook or Google login are supported'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
