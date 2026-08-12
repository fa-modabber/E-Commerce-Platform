<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->filled('sale_date_from')) {
            try {
                $data['sale_date_from'] =
                    convert_jalali_to_gregorian_date(
                        $this->sale_date_from
                    );
            } catch (\Exception) {
                $this->merge([
                    'sale_date_from' => null,
                ]);
            }
        }

        if ($this->filled('sale_date_to')) {
            try {
                $data['sale_date_to'] =
                    convert_jalali_to_gregorian_date(
                        $this->sale_date_to
                    );
            } catch (\Exception) {
                $this->merge([
                    'sale_date_to' => null,
                ]);
            }
        }

        $this->merge($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'primary_image' => ['required', 'image'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image'],

            'name' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string'],

            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'status' => ['required', 'integer'],

            'sale_price' => ['nullable', 'integer'],
            'sale_date_from' => [
                'nullable',
                'date_format:Y-m-d H:i:s',
            ],
            'sale_date_to' => [
                'nullable',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
