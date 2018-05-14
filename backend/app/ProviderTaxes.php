<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProviderTaxes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'providers_id', 
        'taxes_id', 
    ];
}
