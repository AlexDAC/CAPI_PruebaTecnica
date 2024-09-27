<?php

namespace App\Repositories\addresses;

use App\Models\Address;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReadAddressInterface
{
    public function getAll(int $contactId, array $queryFilters):LengthAwarePaginator;
    public function getById(Address $address):Address;
}