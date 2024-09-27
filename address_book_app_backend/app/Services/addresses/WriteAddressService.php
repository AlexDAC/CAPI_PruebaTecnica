<?php

namespace App\Services\addresses;

use App\Models\Address;
use App\Models\Contact;
use App\Repositories\addresses\WriteAddressInterface;

class WriteAddressService implements WriteAddressInterface
{
    /**
     * Create an address for the contact in the database
     *
     * @param array $data
     * 
     * @return void
     */
    public function store(Contact $contact, array $data): void
    {
        $contact->addresses()->create([
            'street' => $data['street'],
            'external_number' => $data['external_number'],
            'internal_number' => isset($data['internal_number']) ? $data['internal_number'] : '',
            'neighbourhood' => $data['neighbourhood'],
            'zip_code' => $data['zip_code'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
        ]);
    }

    /**
     * Update data of a address in the database
     *
     * @param Address $address
     * @param array $data
     * 
     * @return void
     */
    public function update(Address $address, array $data): void
    {
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
    public function delete(Address $address): void
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
