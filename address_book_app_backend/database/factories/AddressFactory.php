<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'street' => fake()->streetAddress(),
            'external_number' => fake()->randomNumber(5),
            'neighbourhood' => fake()->name(),
            'zip_code' => fake()->randomNumber(5),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'contact_id' => fake()->randomElement($contacts),
        ];
    }
}
