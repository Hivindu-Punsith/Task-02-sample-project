<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name', 'last_name', 'company', 'email', 'phone', 'profile_photo',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company');
    }
}
