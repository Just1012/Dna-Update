<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'symble_ar' => 'required|string|max:255',
            'symble_en' => 'required|string|max:255',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'symble_ar.required' => 'The Arabic symbol field is required.',
            'symble_ar.string' => 'The Arabic symbol must be a string.',
            'symble_ar.max' => 'The Arabic symbol may not be greater than 255 characters.',

            'symble_en.required' => 'The English symbol field is required.',
            'symble_en.string' => 'The English symbol must be a string.',
            'symble_en.max' => 'The English symbol may not be greater than 255 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        // Display each error message with Toastr
        foreach ($errorMessages as $errorMessage) {
            Toastr::error($errorMessage, __('validation_custom.Error'));
        }

        parent::failedValidation($validator);
    }
}
