<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Banks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'account',
        'agency',
        'contact',
        'manager',
        'telephone',
        'adress',
        'adress_number',
        'adress_complement',
        'adress_district',
        'zip_code',
        'city',
        'state',
    ];

}
