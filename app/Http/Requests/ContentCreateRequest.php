<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'preview' => ['required', 'string', 'max:250'],
            'text' => ['required', 'string', 'max:800'],
            'delayed_time_publication' => ['nullable', 'string'],
            'file' => ['image', 'nullable', 'dimensions:width=300,height=200', 'max:2400'],
        ];
    }
}
