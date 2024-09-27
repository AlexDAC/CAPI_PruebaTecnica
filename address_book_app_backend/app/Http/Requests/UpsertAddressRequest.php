<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertAddressRequest extends FormRequest
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
            'street' => ['required','string','max:255'],
            'external_number' => ['required','string','max:10'],
            'internal_number' => ['nullable','string','max:10'],
            'neighbourhood' => ['required','string','max:255'],
            'zip_code' => ['required','string','max:10'],
            'city' => ['required','string','max:255'],
            'country' => ['required','string','max:255'],
            'state' => ['required','string','max:255'],
        ];
    }
}
