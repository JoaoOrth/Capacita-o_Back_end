<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'local'        => 'required|string|max:896',
            'description'  => 'required|string|max:1000',
            'image'        => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'placeholder'  => 'required|string|max:255',
            'news_id'      => 'required|exists:news,id',
        ];
    }
}
