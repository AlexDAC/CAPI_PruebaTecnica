<?php

namespace App\Services\contacts;

use App\Helpers\QueryHelper;
use App\Models\Contact;
use App\Repositories\contacts\ReadContactInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadContactService implements ReadContactInterface
{
    /**
     * Get all the contacts from the database with addresses, phone numbers, and emails that it has releated.
     *
     * @param mixed $queryFilters
     * 
     * @return LengthAwarePaginator $contacts
     */
    public function getAll($queryFilters): LengthAwarePaginator
    {
        $contactsQuery = Contact::with([
            'addresses', 
            'emails:id,email,contact_id', 
            'phoneNumbers:id,phone_number,contact_id'
        ]);

        $contactsQuery = QueryHelper::querySearch(
            $contactsQuery,
            $queryFilters['searchBy'],
            [
                'name', 
                'birth_date', 
                'notes', 
                'web_page_url', 
                'company_name'
            ],
            [
                'addresses' => [
                                'street', 
                                'external_number', 
                                'internal_number', 
                                'neighbourhood', 
                                'zip_code', 
                                'city', 
                                'state',
                                'country'
                            ],
                'emails' => ['email'],
                'phoneNumbers' => ['phone_number']
            ]

        );

        if ($queryFilters['sortOrder'] == '' || $queryFilters['sortBy'] == '') {
            $contactsQuery->orderBy('contacts.created_at', 'desc');
        } else {
            $contactsQuery = QueryHelper::querySort(
                $contactsQuery,
                $contactsQuery['sortBy'],
                $contactsQuery['sortOrder'],
                'contacts'
            );
        }

        $contacts = $contactsQuery->paginate($queryFilters['pageSize'] ? $queryFilters['pageSize'] : 20);

        foreach($contacts as $contact) {
            $contact->addresses->each->append('full_address');
        }
 
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
