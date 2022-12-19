<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'fio' => 'required|string|min:10|max:255',
            'address' => 'required|min:3|max:255|string',
            'house' => 'required|string|min:1|max:10',
            'phone' => 'required|string|min:6|max:15',
            'type_id' => 'nullable|integer|exists:message_types,id',
            'responsible_id' => 'required|integer|exists:users,id',
            'uid' => 'nullable|digits:14|unique:messages,uid',
            'contract' => 'digits:1',
            'admin_id' => ''
        ];
    }
//    public function messages(): array
//    {
//        return [
//        ];
//    }
}
