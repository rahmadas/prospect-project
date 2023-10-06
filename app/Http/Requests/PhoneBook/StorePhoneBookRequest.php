<?php

namespace App\Http\Requests\PhoneBook;

use Illuminate\Foundation\Http\FormRequest;

class StorePhoneBookRequest extends FormRequest
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
            'phone_book_csv' => 'required|file|mimes:csv,txt',
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
