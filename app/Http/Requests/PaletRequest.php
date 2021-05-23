<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PaletRequest extends FormRequest
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
            if($this->endpoint == 'api/v1/distributor/palet') {
                $rules = [
                    'palet_id' => 'required',
                    'product_id' => 'required',
                    'order_id' => 'required|numeric'
                ];

            }

            if($this->endpoint == 'api/v1/distributor/palet-delete') {
                $rules = [
                    'palet_id' => 'required',
                    'product_id' => 'required',
                    'order_id' => 'required|numeric'
                ];

            }

            if($this->endpoint == 'api/v1/distributor/palet-complete') {
                $rules = [
                    'product_id' => 'required',
                    'order_id' => 'required|numeric'
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


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
