<?php

namespace App;

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
        'profile',
        'profile_id',
        'date_of_birth',
        'phone',
        'gender',
        'address',
        'email'

    ];

   
}
