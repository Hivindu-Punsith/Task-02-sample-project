<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name', 'email', 'location', 'reg_number', 'telephone', 'logo', 'cover_images', 'website',
    ];

    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'company', 'id');
    }
}
