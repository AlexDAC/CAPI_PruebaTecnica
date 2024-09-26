<?php

namespace App\Repositories\emails;

use App\Models\Contact;

interface WriteEmailInterface
{
    public function executeAction(array $data, Contact $contact): void;
    public function destroy(Contact $contact):void;
}