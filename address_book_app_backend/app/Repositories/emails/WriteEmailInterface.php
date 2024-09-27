<?php

namespace App\Repositories\emails;

use App\Models\Contact;
use App\Models\Email;

interface WriteEmailInterface
{
    public function store(Contact $contact, array $data): void;
    public function update(Email $email, array $data): void;
    public function delete(Email $email): void;
    public function destroy(Contact $contact):void;
}