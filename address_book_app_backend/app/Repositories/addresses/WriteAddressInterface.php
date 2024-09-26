<?php

namespace App\Repositories\addresses;

use App\Models\Contact;

interface WriteAddressInterface
{
    public function executeAction(array $data, Contact $contact): void;
    public function destroy(Contact $contact):void;
}