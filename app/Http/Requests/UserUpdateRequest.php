<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'status' => ['required', 'numeric', Rule::in(array_keys(UserStatus::$list))],
            'roles' => ['required', 'exists:roles,id'],
            'file' => ['image', 'nullable', 'max:2400'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
