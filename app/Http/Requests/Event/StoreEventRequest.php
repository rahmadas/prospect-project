<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => 'required|string',
            'meeting_with' => 'required|string',
            // 'meeting_type' => 'required|in:create_event,create_presentation,event_create_followup_event,create_call_event',
            // 'start_date' => 'required|date',
            // 'end_date' => 'required|date',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'location' => 'required|string',
            // 'reminder' => 'required|YYYY-MM-DD HH:mm:ss',
            'note' => 'required|string',
        ];
    }
}