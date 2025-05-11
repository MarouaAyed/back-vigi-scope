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
        'traitement','dateTraitement', 'status'
    ];


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }   
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
