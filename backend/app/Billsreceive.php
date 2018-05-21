<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billsreceive extends Model
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
        'projects_id',
    ];

}
