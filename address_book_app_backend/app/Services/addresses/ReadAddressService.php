<?php

namespace App\Services\addresses;

use App\Helpers\QueryHelper;
use App\Models\Address;
use App\Repositories\addresses\ReadAddressInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadAddressService implements ReadAddressInterface
{
    /**
     * Get all the addresses of a contact from the database.
     *
     * @param int $contactId
     * @param mixed $queryFilters
     * 
     * @return LengthAwarePaginator $addresses
     */
    public function getAll(int $contactId, array $queryFilters): LengthAwarePaginator
    {
        $addressesQuery = Address::where('contact_id', $contactId);

        $addressesQuery = QueryHelper::querySearch(
            $addressesQuery,
            $queryFilters['searchBy'],
            [
                'street', 
                'external_number', 
                'internal_number', 
                'neighbourhood', 
                'zip_code', 
                'city', 
                'state',
                'country'
            ],
        );

        if ($queryFilters['sortOrder'] == '' || $queryFilters['sortBy'] == '') {
            $addressesQuery->orderBy('addresses.created_at', 'desc');
        } else {
            $addressesQuery = QueryHelper::querySort(
                $addressesQuery,
                $queryFilters['sortBy'],
                $queryFilters['sortOrder'],
                'addresses',
            );
        }
        $addresses = $addressesQuery->paginate($queryFilters['pageSize'] ? $queryFilters['pageSize'] : 20);

        $addresses->each(function ($address) {
            $address->append('full_address');
        });
        return $addresses;
    }

    /**
     * Get a specific address from the database by its identifier
     *
     * @param   Address $address
     *
     * @return Address $address
     */    
    public function getById(Address $address): Address
    {
        return $address;
    }

}
