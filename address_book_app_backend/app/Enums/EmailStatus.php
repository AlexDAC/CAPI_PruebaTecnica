<?php

namespace App\Enums;

enum EmailStatus:string {
    case new = 'new';
    case update = 'update';
    case delete = 'delete';
}
