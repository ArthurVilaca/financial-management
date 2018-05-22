<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PhasesBillings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'amount',
        'due_date',
        'projects_phases_id',
    ];

}
