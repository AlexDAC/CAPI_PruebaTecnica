<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street', 
        'external_number',
        'internal_number',
        'neighbourhood',
        'zip_code',
        'city',
        'state',
        'country',
        'contact_id'
    ];
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'id', 'contact_id');
    }

    public function fullAddress(): Attribute
    {
        $full_address = ($this->street ? $this->street.' ' : ' ')
                        .($this->external_number ? $this->external_number.' ' : ' ') 
                        .($this->internal_number ? $this->internal_number.', ' : '')
                        .($this->neighbourhood ? $this->neighbourhood.', ' : ', ')
                        .($this->zip_code ? $this->zip_code.', ' : ', ')
                        .($this->city ? $this->city.', ' : ', ')
                        .($this->state ? $this->state.', ' : ', ')
                        .($this->country ? $this->country : '');
        
        $full_address = trim($full_address) == ', , , ,' ? 'No Address' : $full_address;

        return
        new Attribute(
            get: fn () => $full_address
        );
    }

}
