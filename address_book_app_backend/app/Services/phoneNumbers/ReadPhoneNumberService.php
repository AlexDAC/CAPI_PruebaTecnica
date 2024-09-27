<?php

namespace App\Services\phoneNumbers;

use App\Helpers\QueryHelper;
use App\Models\PhoneNumber;
use App\Repositories\phoneNumbers\ReadPhoneNumberInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadPhoneNumberService implements ReadPhoneNumberInterface
{
    /**
     * Get all the phone number of a contact from the database.
     *
     * @param int $contactId
     * @param mixed $queryFilters
     * 
     * @return LengthAwarePaginator $phoneNumber
     */
    public function getAll(int $contactId, array $queryFilters): LengthAwarePaginator
    {
        $phoneNumberQuery = PhoneNumber::where('contact_id', $contactId);

        $phoneNumberQuery = QueryHelper::querySearch(
            $phoneNumberQuery,
            $queryFilters['searchBy'],
            [
                'phone_number'
            ],
        );

        if ($queryFilters['sortOrder'] == '' || $queryFilters['sortBy'] == '') {
            $phoneNumberQuery->orderBy('phone_numbers.created_at', 'desc');
        } else {
            $phoneNumberQuery = QueryHelper::querySort(
                $phoneNumberQuery,
                $queryFilters['sortBy'],
                $queryFilters['sortOrder'],
                'phone_numbers',
            );
        }

        return $phoneNumberQuery->paginate($queryFilters['pageSize'] ? $queryFilters['pageSize'] : 20);
    }
    /**
     * Get a specific phone number from the database by its identifier
     *
     * @param   PhoneNumber $phoneNumber
     *
     * @return PhoneNumber $phoneNumber
     */    
    public function getById(PhoneNumber $phoneNumber): PhoneNumber
    {
        return $phoneNumber;
    }

}
