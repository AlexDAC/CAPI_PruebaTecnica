<?php

namespace App\Repositories\phoneNumbers;

use App\Models\Contact;
use App\Models\PhoneNumber;

interface WritePhoneNumberInterface
{
    public function store(Contact $contact, array $data): void;
    public function update(PhoneNumber $phoneNumber, array $data): void;
    public function delete(PhoneNumber $phoneNumber): void;
    public function destroy(Contact $contact):void;
}