<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['name', 'description'];

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
