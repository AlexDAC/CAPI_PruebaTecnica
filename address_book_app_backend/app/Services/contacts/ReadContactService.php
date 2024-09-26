<?php

namespace App\Services\contacts;

use App\Models\Contact;
use App\Repositories\contacts\ReadContactInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadContactService implements ReadContactInterface
{
    /**
     * Get all the contacts from the database with addresses, phone numbers, and emails that it has releated.
     *
     * @return LengthAwarePaginator $contacts
     */
    public function getAll(): LengthAwarePaginator
    {
        $contacts = Contact::with([
            'addresses', 
            'emails:id,email,contact_id', 
            'phoneNumbers:id,phone_number,contact_id'
        ])->select('id','name','birth_date');

        $contacts = $contacts->paginate(20);

        $contacts->each(function (&$contact) {
            $contact->addresses->each->append('full_address');
        });
        return $contacts;
    }

    /**
     * Get a specific contact from the database by its identifier
     *
     * @param   Contact  $contact
     *
     * @return  Contact $contact
     */    
    public function getById(Contact $contact): Contact
    {
        return $contact->load(
                            'addresses',
                            'emails:id,email,contact_id',
                            'phoneNumbers:id,phone_number,contact_id',
                        );
    }

}
