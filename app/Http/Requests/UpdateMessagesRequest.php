<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fio' => 'required|string|min:10|max:255',
            'address' => 'required|min:4|max:255|string',
            'house' => 'required|string|min:1|max:10',
            'phone' => 'required|string|min:6|max:15',
            'type_id' => 'required|integer|exists:message_types,id',
            'responsible_id' => 'required|integer|exists:users,id',
            'status_id' => 'required|integer|exists:status_types,type_id',
            'uid' => 'nullable|digits:14',
            'contract' => 'digits:1',
            'plan' => 'nullable|date',
            'closed' => '',
        ];
    }
}
