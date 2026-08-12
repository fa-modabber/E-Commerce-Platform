<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFooterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'col_1_title' => ['required', 'string'],
            'col_1_body_1' => ['required', 'string'],
            'col_1_body_2' => ['nullable', 'string'],
            'col_2_title' => ['required', 'string'],
            'col_2_body' => ['required', 'string'],
            'col_3_title' => ['required', 'string'],
            'col_3_body' => ['required', 'string'],
            'social_media_1' => ['nullable', 'string'],
            'social_media_2' => ['nullable', 'string'],
            'social_media_3' => ['nullable', 'string'],
            'social_media_4' => ['nullable', 'string'],
            'copyright' => ['required', 'string']
        ];
    }
}
