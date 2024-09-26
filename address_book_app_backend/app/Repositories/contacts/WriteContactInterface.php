<?php

namespace App\Repositories\contacts;

use App\Models\Contact;

interface WriteContactInterface
{
    public function store(array $data): Contact;
    public function update(Contact $contact, array $data): Contact;
    public function delete(Contact $contact): void;
}