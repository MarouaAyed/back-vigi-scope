<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'type',
        'status',
        'company',
        'vat_number',
        'notes',
        'number_of_employees',
        'collaboration_start_date',
        'medical_center',

        'address_name',
        'address_street',
        'address_postal_code',
        'address_city',
        'address_country',
    ];

    /**
     * Get the managers for the client.
     */
    public function managers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the employees for the client.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
