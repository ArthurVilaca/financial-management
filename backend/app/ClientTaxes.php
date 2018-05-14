<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClientTaxes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clients_id', 
        'taxes_id', 
    ];
}
