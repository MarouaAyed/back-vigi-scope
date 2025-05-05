<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id',
        'employee_id',
        'classification_id',
        'name',
        'email',
        'subject',
        'sujet',
        'commentaire',
        'status'
    ];
}
