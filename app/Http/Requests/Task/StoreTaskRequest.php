<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'contact_id' => 'required',
            'title' => 'required|string',
            'note' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'priority' => 'required|in:low,medium,hight',
            'reminder' => 'required|date_format:H:i:s',
            // 'status' => 'required|in:completed,not_completed,due_today',
            'relate_to' => 'nullable|integer'
        ];
    }
}
