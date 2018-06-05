<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Projects extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'status',
        'amount',
        'clients_id',
        'expiration_date',
        'banks_id',
    ];

}
