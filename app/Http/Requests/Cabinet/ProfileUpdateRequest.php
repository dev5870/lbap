<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'username' => ['string', 'nullable', 'max:15'],
            'about' => ['string', 'nullable', 'max:25'],
            'skill' => ['string', 'nullable', 'max:300'],
            'city' => ['string', 'nullable', 'max:25'],
            'telegram' => ['string', 'nullable', 'max:50'],
            'description' => ['string', 'nullable', 'max:300'],
        ];
    }
}
