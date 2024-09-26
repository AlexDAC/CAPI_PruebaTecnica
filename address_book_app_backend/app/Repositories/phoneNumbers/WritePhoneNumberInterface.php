<?php

namespace App\Repositories\phoneNumbers;

use App\Models\Contact;

interface WritePhoneNumberInterface
{
    public function executeAction(array $data, Contact $contact): void;
    public function destroy(Contact $contact):void;
}