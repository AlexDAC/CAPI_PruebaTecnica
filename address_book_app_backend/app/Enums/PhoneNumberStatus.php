<?php

namespace App\Enums;

enum PhoneNumberStatus:string {
    case new = 'new';
    case update = 'update';
    case delete = 'delete';
}
