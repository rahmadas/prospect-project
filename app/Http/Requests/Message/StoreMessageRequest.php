<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            // 'user_id' => 'required',
            // 'contact_id' => 'required',
            'message_template_id' => 'required',
            'message' => 'required|string',
            // 'status' => 'required|in:pending,success,failed'
            'name' => 'required|string',
            'phone_number' => 'required|string',
            // 'attachments.*' => 'required|file|mimes:pdf,doc,docx,mp4,avi,mov,xlsx,xls,jpg,jpeg,png,gif|max:7048'
        ];
    }
}
