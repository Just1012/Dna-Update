<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Validation\Validator;

class MenuItemRequest extends FormRequest
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
            'menu_id' => 'required|exists:menus,id', // Ensure menu_id exists in the menus table
            'items' => 'required|array',
            'items.*' => [
                'required',
            ],
        ];
    }


    public function messages()
    {
        return [
            'item_id.required' => 'The item is required.',
            'item_id.unique' => 'The selected item already exists for this menu.',
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
