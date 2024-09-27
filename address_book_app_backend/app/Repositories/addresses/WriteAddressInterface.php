<?php

namespace App\Repositories\addresses;

use App\Models\Address;
use App\Models\Contact;

interface WriteAddressInterface
{
    public function store(Contact $contact, array $data): void;
    public function update(Address $address, array $data): void;
    public function delete(Address $address): void;
    public function destroy(Contact $contact):void;
}