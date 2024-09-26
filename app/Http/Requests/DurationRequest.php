<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;

class DurationRequest extends FormRequest
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
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'num_weeks' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'The Arabic title is required.',
            'title_ar.string' => 'The Arabic title must be a string.',
            'title_en.required' => 'The English title is required.',
            'title_en.string' => 'The English title must be a string.',
            'num_weeks.required' => 'The number of weeks is required.',
            'num_weeks.integer' => 'The number of weeks must be an integer.',
            'num_weeks.min' => 'The number of weeks must be at least :min.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        // Display each error message with Toastr
        foreach ($errorMessages as $errorMessage) {
            toastr()->error($errorMessage, __('validation_custom.Error'));
        }

        parent::failedValidation($validator);
    }
}
