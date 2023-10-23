<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'inviter_referral_code ' => 'sometimes|numeric',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'foto_profile' => 'sometimes|mimes:jpg,bmp,png'
            // 'pro_feature_id' => 'required'
            // 'status' => 'required|in:pro,free',
        ];
    }
}
