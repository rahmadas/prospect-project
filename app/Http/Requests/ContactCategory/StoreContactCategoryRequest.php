<?php

namespace App\Http\Requests\ContactCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'contact_id' => 'required'
        ];
    }
}
