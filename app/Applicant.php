<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model 
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni', 
        'names',
        'surname',
        'gender',
        'type',
        'institutional_email',
        'photo',
        'code',
        'school_id',
        'phone',
        'mobile',
        'personal_email',
        'address',
        'description'

    ];

   
}
