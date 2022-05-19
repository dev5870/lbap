<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
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
        // todo: check correct
        return [
            'cancel' => ['exclude_if:confirm,confirm', 'string'],
            'confirm' => ['exclude_if:cancel,cancel', 'string'],
        ];
    }
}
