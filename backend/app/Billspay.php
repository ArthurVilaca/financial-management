<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billspay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'comments',
        'amount',
        'projects_phases_id',
        'due_date',
    ];

}
