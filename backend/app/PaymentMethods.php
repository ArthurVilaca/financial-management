<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PaymentMethods extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}
