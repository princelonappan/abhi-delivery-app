<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;


class AddressRequest extends FormRequest
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
            if($this->endpoint == 'api/v1/address') {
                $addressableIdRule = 'required_with:adressable_type';
                if ($this->has('addressable_type')) {
                    $className =  Relation::getMorphedModel($this->addressable_type);
                    if(empty($className)) {
                        abort(401, 'The addressable type doesnt exist');
                    }
                    $class = new $className;
                    $addressableIdRule .= '|exists:' . $class->getTable() . ',id';
                }
                $rules = [
                    'addressable_id' => $addressableIdRule,
                    'addressable_type' => 'required_with:addressable_id|in:customer,distributor,branch',
                    'address_type' => 'required',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip' => 'required',
                    'country' => 'required'
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
            'addressable_id.exists' => 'Only address of existing customer, distributor or branch can be added',
            'addressable_type.exists' => 'Addressable type should be customer, distributor or branch'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = response()->json($validator->errors(),400);
        throw new HttpResponseException($errors);
    }
}
