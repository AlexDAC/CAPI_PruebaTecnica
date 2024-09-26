<?php

namespace App\Enums;

enum AddressStatus:string {
    case new = 'new';
    case update = 'update';
    case delete = 'delete';
}
