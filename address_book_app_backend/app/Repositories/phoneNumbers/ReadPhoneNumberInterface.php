<?php

namespace App\Repositories\phoneNumbers;

use App\Models\PhoneNumber;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReadPhoneNumberInterface
{
    public function getAll(int $contactId, array $queryFilters):LengthAwarePaginator;
    public function getById(PhoneNumber $phoneNumber):PhoneNumber;
}