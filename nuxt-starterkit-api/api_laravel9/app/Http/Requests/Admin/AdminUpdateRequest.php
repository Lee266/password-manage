<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AdminUpdateRequest extends FormRequest
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
            'data.name' => [
                'bail',
                'required',
                'max:255',
            ],
            'data.email' => [
                'bail',
                'required',
                'email',
                'max:255',
            ],
            'data.password' => [
                'nullable',
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
