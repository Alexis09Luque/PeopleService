<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni', 
        'code',
        'names',
        'surname',
        'profile_id',
        'date_of_birth',
        'phone',
        'mobile',
        'gender',
        'address',
        'email',
        'photo'

    ];

   
}
