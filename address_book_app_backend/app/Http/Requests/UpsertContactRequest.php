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
            'company' => ['nullable', 'string', 'max:255'],
            'emails' => ['nullable', 'array', 'min:1' ],
            'emails.*' => ['array'],
            'emails.*.id' => ['required', 'integer'],
            'emails.*.email' => ['required', 'email', 'max:255'],
            'emails.*.status' => ['required','string', Rule::enum(EmailStatus::class)],
            'addresses' => ['nullable', 'array', 'min:1' ],
            'addresses.*' => ['array'],
            'addresses.*.id' => ['required', 'integer'],
            'addresses.*.street' => ['required','string','max:255'],
            'addresses.*.external_number' => ['required','string','max:10'],
            'addresses.*.internal_number' => ['nullable','string','max:10'],
            'addresses.*.neighbourhood' => ['required','string','max:255'],
            'addresses.*.zip_code' => ['required','string','max:10'],
            'addresses.*.city' => ['required','string','max:255'],
            'addresses.*.country' => ['required','string','max:255'],
            'addresses.*.state' => ['required','string','max:255'],
            'addresses.*.status' => ['required', 'string', Rule::enum(AddressStatus::class)],
            'phone_numbers' => ['required', 'array', 'min:1' ],
            'phone_numbers.*' => ['array'],
            'phone_numbers.*.id' => ['required', 'integer'],
            'phone_numbers.*.phone_number' => ['required','string','max:13', 'min:10'],
            'phone_numbers.*.status' => ['required', 'string', Rule::enum(PhoneNumberStatus::class)],
        ];
    }
}
