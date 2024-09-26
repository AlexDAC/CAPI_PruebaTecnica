<?php

namespace App\Services\addresses;

use App\Models\Address;
use App\Models\Contact;
use App\Repositories\addresses\WriteAddressInterface;

class WriteAddressService implements WriteAddressInterface
{
    /**
     * execute and action depending of the type of status of the address, the actions can be:
     * create, update or delete
     *
     * @param array $data
     * @param Contact $contact
     * 
     * @return void
     */    
    public function executeAction(array $data, Contact $contact): void
    {
        if(!isset($data['addresses']) || empty($data['addresses'])){
            return;
        }
        foreach($data['addresses'] as $address){
            switch($address["status"]){
                case "new":
                    $this->store($contact, $address);
                break;
                case "update":
                    $this->update($address['id'], $address);
                    break;
                case "delete":
                    $this->delete($address['id']);
                    break;
            }
        }
    }

    /**
     * Create an contact in the database
     *
     * @param array $data
     * 
     * @return void
     */
    private function store(Contact $contact, array $address): void
    {
        $contact->addresses()->create([
            'street' => $address['street'],
            'external_number' => $address['external_number'],
            'internal_number' => isset($address['internal_number']) ? $address['internal_number'] : '',
            'neighbourhood' => $address['neighbourhood'],
            'zip_code' => $address['zip_code'],
            'city' => $address['city'],
            'state' => $address['state'],
            'country' => $address['country'],
        ]);
    }

    /**
     * Update data of a address in the database
     *
     * @param int $addressId
     * @param array $data
     * 
     * @return void
     */
    private function update(int $addressId, array $data): void
    {
        $address = Address::find($addressId);
        $address->update([
            'street' => $data['street'],
            'external_number' => $data['external_number'],
            'internal_number' => isset($data['internal_number']) ? $data['internal_number'] : $address['internal_number'],
            'neighbourhood' => $data['neighbourhood'],
            'zip_code' => $data['zip_code'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
        ]);
    }

    
    /**
     * Delete a single address from the database
     *
     * @param Address $address
     * 
     * @return void
     */
    private function delete(Address $address): void
    {
        $address->delete();
    }

    /**
     * Delete all the addresses related to Contact from the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function destroy(Contact $contact): void
    {
        $contact->addresses()->delete();
    }
}
