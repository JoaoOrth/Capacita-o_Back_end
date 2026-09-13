<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class JournalistRequest extends FormRequest
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
            'name' => 'required|string|max:896',
            'email' => 'required|email|max:255',
            'workplace' => 'required|string|max:896',
            'salary' => 'required|numeric|min:1621',
        ];
    }
}
