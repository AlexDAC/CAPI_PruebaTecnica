<?php

namespace App\Services\emails;

use App\Models\Contact;
use App\Models\Email;
use App\Repositories\emails\WriteEmailInterface;

class WriteEmailService implements WriteEmailInterface 
{       
    /**
     * Create an email for the contact in the database
     *
     * @param Contact $contact
     * @param array $data
     * 
     * @return void
     */
    public function store(Contact $contact, array $data): void
    {
        $contact->emails()->create(["email" => $data['email']]);
    }

    /**
     * Update data of an email in the database
     *
     * @param Email $email
     * @param array $data
     * 
     * @return void
     */
    public function update(Email $email, array $data): void
    {
        $email->update([
            "email" => $data['email']
        ]);
    }

    
    /**
     * Delete a single email from the database
     *
     * @param Email $email
     * 
     * @return void
     */
    public function delete(Email $email): void
    {
        $email->delete();
    }

    /**
     * Delete all the emails related to Contact from the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function destroy(Contact $contact): void
    {
        $contact->emails()->delete();
    }
}
