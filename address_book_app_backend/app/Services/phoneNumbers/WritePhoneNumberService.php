<?php

namespace App\Services\phoneNumbers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Repositories\phoneNumbers\WritePhoneNumberInterface;

class WritePhoneNumberService implements WritePhoneNumberInterface
{

    public function executeAction(array $data, Contact $contact): void
    {
        if(!isset($data['phone_numbers']) || empty($data['phone_numbers'])){
            return;
        }
        foreach($data['phone_numbers'] as $phoneNumber){
            switch($phoneNumber["status"]){
                case "new":
                    $this->store($contact, $phoneNumber);
                break;
                case "update":
                    $this->update($phoneNumber['id'], $phoneNumber);
                    break;
                case "delete":
                    $this->delete($phoneNumber['id']);
                    break;
            }
        }
    }

    /**
     * Create a phone number in the database
     *
     * @param Contact $contact
     * @param array $data
     * 
     * @return void
     */
    private function store(Contact $contact, array $phoneNumber): void
    {
        $contact->phoneNumbers()->create(['phone_number' => $phoneNumber['phone_number']]);
    }

    /**
     * Update data of a phone number in the database
     *
     * @param int $phoneNumberId
     * @param array $data
     * 
     * @return void
     */
    private function update(int $phoneNumberId, array $data): void
    {
        $phoneNumber = PhoneNumber::find($phoneNumberId);
        $phoneNumber->update([
            "phone_number" => $data["phone_number"]
        ]);
    }

    
    /**
     * Delete a single address from the database
     *
     * @param PhoneNumber $phoneNumber
     * 
     * @return void
     */
    private function delete(PhoneNumber $phoneNumber): void
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
