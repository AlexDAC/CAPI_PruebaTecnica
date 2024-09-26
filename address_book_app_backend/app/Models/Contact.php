<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'notes', 
        'birth_date', 
        'web_page_url',
        'company_name',
    ];

    protected $casts = [
        'birth_date' => 'date:Y-m-d',  
    ];
    

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'contact_id', 'id');
    }

    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class, 'contact_id', 'id');
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'contact_id', 'id');
    }


}
