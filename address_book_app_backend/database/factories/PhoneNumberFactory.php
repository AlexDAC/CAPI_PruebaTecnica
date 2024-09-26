<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneNumber>
 */
class PhoneNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contacts = Contact::pluck('id')->toArray();
        return [
            'phone_number' => fake()->numerify('##########'),
            'contact_id' => fake()->randomElement($contacts)
        ];
    }
}
