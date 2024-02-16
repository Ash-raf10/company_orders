<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'company_code' => 'required|string|max:100|unique:companies,company_code,except,id',
            'email' => 'required|email|unique:companies,email,except,id',
            'commercial_record_number' => 'required|string|max:100',
            'commercial_record_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            'logo' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
            'country_code' => 'required|exists:countries,id',
        ];
    }
}
