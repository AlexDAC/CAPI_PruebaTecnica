<?php

namespace App\Repositories\contacts;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

interface ReadContactInterface
{
    public function getAll():LengthAwarePaginator;
    public function getById(Contact $contact):Contact;
}