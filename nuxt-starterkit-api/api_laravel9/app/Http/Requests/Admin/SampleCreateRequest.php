<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\ValidateEmail;

class SampleCreateRequest extends FormRequest
{
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
        return [
            'name' => [
                'bail',
                'required',
                'max:255',
            ],
            'postcode' => [
                'bail',
                'required',
                'numeric',
            ],
            'email' => [
                'bail',
                'required',
                'max:255',
                new ValidateEmail(), // if need custom validation message
            ],
            'password' => [
                'bail',
                'required',
                'min:6'
            ]
        ];
    }

    /**
     * Handle a failed validation for custom response
     *
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        return errorValidation($validator->errors());
    }
}
