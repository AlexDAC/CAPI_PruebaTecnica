<?php

namespace App\Repositories\emails;

use App\Models\Email;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReadEmailInterface
{
    public function getAll(int $contactId, array $queryFilters):LengthAwarePaginator;
    public function getById(Email $email):Email;
}