<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Email;
use App\Models\PhoneNumber;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Contact::factory(500)->create();
        Address::factory(500)->create();
        PhoneNumber::factory(500)->create();
        Email::factory(500)->create();
    }
}
