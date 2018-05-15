<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CostCenters extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

}
