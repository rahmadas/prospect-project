<?php

namespace App\Http\Requests\MessageTemplate;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageTemplateRequest extends FormRequest
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
            // 'message_template_id' => 'required',
            'title' => 'required|string',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,mp4,avi,mov,xlsx,xls,jpg,jpeg,png,gif'
        ];
    }
}
