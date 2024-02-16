<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'city_from' => 'required|string|max:50',
            'city_to' => 'required|string|max:50',
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'images' => 'sometimes|array',
            'images.*' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price' => 'Price should be decimal and upto 2 digits only',
        ];
    }
}
