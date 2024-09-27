<?php

namespace App\Services\phoneNumbers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Repositories\phoneNumbers\WritePhoneNumberInterface;

class WritePhoneNumberService implements WritePhoneNumberInterface
{
    /**
     * Create a phone number for the contact in the database
     *
     * @param Contact $contact
     * @param array $data
     * 
     * @return void
     */
    public function store(Contact $contact, array $data): void
    {
        $contact->phoneNumbers()->create(['phone_number' => $data['phone_number']]);
    }

    /**
     * Update data of a phone number in the database
     *
     * @param PhoneNumber $phoneNumber
     * @param array $data
     * 
     * @return void
     */
    public function update(PhoneNumber $phoneNumber, array $data): void
    {
        $phoneNumber->update([
            "phone_number" => $data["phone_number"]
        ]);
    }

    
    /**
     * Delete a single phone number from the database
     *
     * @param PhoneNumber $phoneNumber
     * 
     * @return void
     */
    public function delete(PhoneNumber $phoneNumber): void
    {
        $phoneNumber->delete();
    }

    /**
     * Delete all the phone numbers related to contact from the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function destroy(Contact $contact): void
    {
        $contact->phoneNumbers()->delete();
    }

}
