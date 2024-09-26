<?php

namespace App\Services\contacts;

use App\Models\Contact;
use App\Models\Email;
use App\Repositories\contacts\WriteContactInterface;

class WriteContactService implements WriteContactInterface 
{


    /**
     * Create an contact in the database
     *
     * @param array $data
     * 
     * @return void
     */
    public function store(array $data): Contact
    {
        $contact = Contact::create($data);
        return $contact;
    }

    /**
     * Update data of a contact in the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    /**
     * Delete a single contact from the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function delete(Contact $contact): void
    {
        $contact->delete();
    }

}
