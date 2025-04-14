<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
    ];
}
