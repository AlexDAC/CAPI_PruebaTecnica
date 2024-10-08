<?php

namespace App\Http\Requests;

use App\Enums\AddressStatus;
use App\Enums\EmailStatus;
use App\Enums\PhoneNumberStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'web_page_url' => ['nullable', 'url', 'max:300'],
            'company_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
