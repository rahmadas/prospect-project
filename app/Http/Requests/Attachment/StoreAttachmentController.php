<?php

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentController extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message_template_id' => 'required',
            'file' => 'required|nullable|file|mimes:pdf,doc,docx,mp4,avi,mov,xlsx,xls,jpg,jpeg,png,gif',
            // 'type' => 'enum',
        ];
    }
}
