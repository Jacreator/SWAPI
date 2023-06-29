<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'gender' => 'required|string',
            'sortDirection' => 'required|string',
            'sort' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'gender.string' => 'Please enter a gender as male or female.',
            'sortDirection.string' => 'Please enter a sort direction as desc or asc',
        ];
    }
}
