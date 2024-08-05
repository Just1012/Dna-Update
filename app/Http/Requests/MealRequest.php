<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;

class MealRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'type' => 'required|in:0,1',
            'calories_ar' => 'required|string|max:200',
            'calories_en' => 'required|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'Title (Arabic) is required.',
            'title_ar.string' => 'Title (Arabic) must be a string.',
            'title_ar.max' => 'Title (Arabic) may not be greater than 255 characters.',

            'title_en.required' => 'Title (English) is required.',
            'title_en.string' => 'Title (English) must be a string.',
            'title_en.max' => 'Title (English) may not be greater than 255 characters.',

            'type.required' => 'Meal type is required.',
            'type.in' => 'Invalid meal type selected.',

            'calories_ar.required' => 'Calories (Arabic) is required.',
            'calories_ar.string' => 'Calories (Arabic) must be a string.',
            'calories_ar.max' => 'Calories (Arabic) may not be greater than 200 characters.',

            'calories_en.required' => 'Calories (English) is required.',
            'calories_en.string' => 'Calories (English) must be a string.',
            'calories_en.max' => 'Calories (English) may not be greater than 200 characters.',
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
