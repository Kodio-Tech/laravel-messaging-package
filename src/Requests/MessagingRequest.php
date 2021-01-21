<?php

namespace Kodio\LaravelMessaging\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessagingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'target_user_id' => [
                'required', 'exists:users,id'
            ],
            'message' => [
                'required', 'string'
            ],
            'title' => [
                'required', 'string'
            ],
        ];
    }
}
