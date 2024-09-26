<?php

namespace App\Http\Requests;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
class ItemUpdateRequest extends FormRequest
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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category' => 'nullable|exists:categories,id',
            'subCategory' => 'nullable|exists:sub_categories,id',
            'subSubCategory' => 'nullable|exists:sub_sub_categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ];
    }

    public function messages()
    {
        return [
            'title_ar.required' => 'The Arabic title is required.',
            'title_en.required' => 'The English title is required.',
            'title_ar.string' => 'The Arabic title must be a string.',
            'title_en.string' => 'The English title must be a string.',
            'title_ar.max' => 'The Arabic title may not be greater than :max characters.',
            'title_en.max' => 'The English title may not be greater than :max characters.',
            'category.exists' => 'The selected category does not exist.',
            'subCategory.exists' => 'The selected subcategory does not exist.',
            'subSubCategory.exists' => 'The selected sub-subcategory does not exist.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
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
